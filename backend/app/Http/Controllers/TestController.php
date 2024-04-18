<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        dd(getenv('STRIPE_SECRET_KEY'));
    }
}
