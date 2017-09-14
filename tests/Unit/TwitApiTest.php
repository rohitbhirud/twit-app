<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TwitApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_tweets_from_home_timeline()
    {
        $user = factory(User::class)->make();

        $this->actingAs($user, 'api');

        $response = $this->json('get', '/api/tweets/home');
            
        $response->assertStatus(200)
                 ->assertSeeText('users')
                 ->assertDontSeeText('errors');
    }
}
