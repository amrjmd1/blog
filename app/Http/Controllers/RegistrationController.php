<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;


class RegistrationController extends Controller
{
    public function create()
    {

        return view('register');
    }

    public function store(Request $request)
    {
        $U =User::where('email', $request->input('email'))->first();
        if ($U == null) {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->save();

            // add role
            $user->roles()->attach(Role::where('name', 'user')->first());


            auth()->login($user);

            return redirect('/');
        }
        return back()->withErrors([
            'massage' => 'This E-mail already exists',
        ]);

    }
}
