<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function create()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        if (auth()->attempt(request(['email', 'password']))) {
            return redirect('/');
        } else {
            return back()->withErrors([
                'massage' => 'Email or Password not corrected !',
            ]);
        }
    }


    public function destroy()
    {
        auth()->logout();
        return redirect('/');
    }
}
