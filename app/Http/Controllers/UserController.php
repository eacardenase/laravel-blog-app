<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $incomingField = $request->validate([
            'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        $incomingField['password'] = bcrypt($incomingField['password']);

        User::create($incomingField);

        return "Hello from register function";
    }

    public function login(Request $request)
    {
        $incomingFields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);

        if (auth()->attempt([
            'username' => $incomingFields['loginusername'],
            'password' => $incomingFields['loginpassword']
        ])) {
            $request->session()->regenerate(); // creates session cookie

            return 'Congrats!!!';
        } else {
            return 'Sorry :c';
        }
    }

    public function logout()
    {
        auth()->logout();

        return 'You are now logged out';
    }

    public function showCorrectHomePage()
    {
        if (auth()->check()) { // checks if user is authenticated
            return view('homepage-feed');
        } else {
            return view('homepage');
        }
    }
}
