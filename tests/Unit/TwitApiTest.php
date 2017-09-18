<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Twit;
use Storage;

class TwitApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_tweets_from_home_timeline()
    {
        $response = Storage::get('responses/home_timeline.txt');

        Twit::shouldReceive('home')
            ->andReturn($response);
    }

    /** @test */
    public function it_returns_ids_of_followers()
    {
        $response = Storage::get('responses/followers_ids.txt');

        Twit::shouldReceive('followersIDs')
            ->andReturn($response);
    }
}
