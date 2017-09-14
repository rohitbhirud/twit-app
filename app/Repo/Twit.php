<?php

namespace App\Repo;

use Abraham\TwitterOAuth\TwitterOAuth;
use App\User;
use Illuminate\Http\Request;

/**
* Twitter Api Client
*/
class Twit
{
    /**
     * @var string
     */
    private $endpoint = "https://api.twitter.com/1.1/";


    /**
    * @var string
    */
    private $consumer_key;

    /**
     * @var string
     */
    private $consumer_secret;

    /**
     * @var string
     */
    private $access_token;

    /**
     * @var string
     */
    private $access_token_secret;

    public function __construct()
    {
        $this->initKeys();
    }

    public function home()
    {
        return ['users'];
    }

    public function redirect()
    {
        $connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret);

        // Get temporary request oauth token & secret
        $request_token = $connection->oauth(
                                        'oauth/request_token',
                                        ['oauth_callback' =>  route('auth.callback') ]
        );

        // Save temporary request token $ secret into session
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

        \Cache::forever($access_token['user_id'] . ':access_token', $access_token);

        $user = User::firstOrNew([
                'twitter_id' => $access_token['user_id'],
                'nickname' => $access_token['screen_name']
            ]);

        $user->oauth_token = $access_token['oauth_token'];
        $user->oauth_token_secret = $access_token['oauth_token_secret'];
        $user->save();

        \Auth::login($user);
    }

    public function initKeys()
    {
        $this->consumer_key = config('twit.consumer_key');
        $this->consumer_secret = config('twit.consumer_secret');
        $this->access_token = config('twit.access_token');
        $this->access_token_secret = config('twit.access_token_secret');

        if (!isset($this->consumer_key,
                   $this->consumer_secret,
                   $this->access_token,
                   $this->access_token_secret)) {
            throw new \Exception("Invalid / Undefined Consumer or Access Keys");
        }
    }
}
