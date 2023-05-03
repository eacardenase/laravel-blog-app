<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function homePage() {
        // imagine we loaded data from the database
        $myName = "Edwin";
        $catName = 'Mango';
        $animals = ["Mango", "Apollo", "Coco"];

        return view('homepage', [
            'name' => $myName,
            'catName' => $catName,
            'animalsArray' => $animals
        ]);
    }

    public function aboutPage() {
        return '<h1>About page!</h1><a href="/">Back to home</a>';
    }
}
