<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Http\Resources\CategoryTreeResource;

class TestController extends Controller
{
    public function index()
    {
        return Category::getActiveAsTree(CategoryTreeResource::class);
    }
}