<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_shows_login_page_to_guest()
    {
        $this->get(route('home'))
            ->assertRedirect(route('login'));

        $this->get(route('login'))
            ->assertStatus(200)
            ->assertSee('Sign In');
    }

    /** @test */
    public function it_dont_show_login_page_to_authenticated_user()
    {
        $user = factory(User::class)->make();

        $this->actingAs($user)
            ->get(route('login'))
            ->assertRedirect(route('home'));
    }
}
