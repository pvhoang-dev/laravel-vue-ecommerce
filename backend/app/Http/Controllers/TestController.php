<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index()
    {
        dd(Storage::disk('public')->get('images/5J32XVrtpWDy7HiQ/c5e3nklwCsYswQVm.jpeg'));
        dd(Storage::disk('s3')->allFiles());
    }
}
