<?php

namespace App\Repo;

use Abraham\TwitterOAuth\TwitterOAuth;
use Cache;
use Auth;
use App\User;

/**
* Twit Oauth Helper Trait
*/
trait TwitOAuth
{
    private function getOAuthInstance()
    {
        $access_keys = $this->getAccessKeys();

        return new TwitterOAuth(
            $this->consumer_key,
            $this->consumer_secret,
            $access_keys['oauth_token'],
            $access_keys['oauth_token_secret']
        );
    }

    private function getAccessKeys()
    {
        $user = Auth::user();

        return Cache::remember("user:$user->id:keys", 1440, function () use ($user) {
            return['oauth_token' => $user->oauth_token,
                   'oauth_token_secret' => $user->oauth_token_secret];
        });
    }

    public function redirect()
    {
        $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret);

        // Get temporary request oauth token & secret
        $request_token = $connection->oauth(
            'oauth/request_token',
            ['oauth_callback' =>  route('auth.callback') ]
        );

        if ($request_token['oauth_callback_confirmed'] !== "true") {
            return false;
        }

        // Save temporary request token & secret into session
        session([
            'oauth_token' => $request_token['oauth_token'],
            'oauth_token_secret' => $request_token['oauth_token_secret']
        ]);


        // Generating Twitter Auth redirect url
        $url = $connection->url(
            'oauth/authorize',
            ['oauth_token' => $request_token['oauth_token']]
        );

        return redirect($url);
    }

    public function handle()
    {
        $request = [];
        $request_token['oauth_token'] = session('oauth_token');
        $request_token['oauth_token_secret'] = session('oauth_token_secret');

        // Check if user denied the autorization on twitter
        if (request()->has('denied') === true) {
            return redirect()->route('login');
        }

        // Check if temporary oauth token exist & match new oauth token
        if (request()->session()->exists('oauth_token') &&
            $request_token['oauth_token'] !== request('oauth_token')) {
            throw new \Exception("Invalid Authorization Token");
        }

        $connection = new TwitterOAuth(
            $this->consumer_key,
            $this->consumer_secret,
            $request_token['oauth_token'],
            $request_token['oauth_token_secret']
        );

        // Get permanent access token & secret
        $access_token = $connection->oauth(
            "oauth/access_token",
            ["oauth_verifier" => request('oauth_verifier')]
        );

        $user = User::firstOrNew([
                'twitter_id' => $access_token['user_id'],
                'nickname' => $access_token['screen_name']
            ]);

        $user->oauth_token = $access_token['oauth_token'];
        $user->oauth_token_secret = $access_token['oauth_token_secret'];
        $user->save();

        \Auth::login($user);

        $this->saveUserProfile();
    }
}
