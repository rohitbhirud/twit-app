<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class UserTest extends DuskTestCase
{
    /** @test */
    public function it_redirects_to_twitter()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route('auth.redirect'))
                    ->assertPathBeginsWith('/oauth/authorize');
        });
    }
}
