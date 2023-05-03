<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function homePage() {
        return '<h1>Home page!</h1><a href="/about">Back to about</a>';
    }

    public function aboutPage() {
        return '<h1>About page!</h1><a href="/">Back to home</a>';
    }
}
