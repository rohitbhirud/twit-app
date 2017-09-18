<?php

namespace App\Repo;

use Abraham\TwitterOAuth\TwitterOAuth;
use Illuminate\Http\Request;
use App\User;
use Cache;
use Auth;

/**
* Twitter Api Client
*/
class Twit
{
    use TwitOAuth;

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
        $uri = 'statuses/home_timeline';

        return Cache::remember('user:' . Auth::id() . ':' . $uri, 100, function () use ($uri) {
            return $this->get($uri, ['count' => 11]);
        });
    }

    public function followersIDs()
    {
        $uri  = 'followers/ids';

        return Cache::remember('user:' . Auth::id() . ':' . $uri, 2, function () use ($uri) {
            return $this->get($uri, ['count' => 5000]);
        });
    }

    public function get($uri, $params = [])
    {
        $connection = $this->getOAuthInstance();

        return $connection->get($uri, $params);
    }
    
    private function saveUserProfile()
    {
        $userInfo = $this->get('account/verify_credentials');

        $user = Auth::user();

        if (isset($user->name)) {
            return;
        }

        $user->name = $userInfo->name;
        $user->avatar = $userInfo->profile_image_url_https;
        $user->save();

        Cache::forever("user:$user->id:info", $userInfo);
    }

    private function initKeys()
    {
        $this->consumer_key = config('twit.consumer_key');
        $this->consumer_secret = config('twit.consumer_secret');
        $this->access_token = config('twit.access_token');
        $this->access_token_secret = config('twit.access_token_secret');

        if (!isset(
            $this->consumer_key,
            $this->consumer_secret,
            $this->access_token,
            $this->access_token_secret
        )) {
            throw new \Exception("Invalid / Undefined Consumer or Access Keys");
        }
    }
}
