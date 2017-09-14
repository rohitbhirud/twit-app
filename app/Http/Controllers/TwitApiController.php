<?php

namespace App\Http\Controllers;

use Twit;
use Illuminate\Http\Request;

class TwitApiController extends Controller
{
    public function home()
    {
        return Twit::home();
    }
}
