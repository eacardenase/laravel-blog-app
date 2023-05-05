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
        $user = User::create($incomingField);

        auth()->login($user); // log user in after registration

        return redirect('/')->with('success', 'Thank you for creating an account.');
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

            return redirect('/')->with('success', 'You have successfully logged in.');
        } else {
            return redirect('/')->with('failure', 'Invalid login.');
        }
    }

    public function logout()
    {
        auth()->logout();

        return redirect('/')->with('success', 'You are now logged out.');
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
