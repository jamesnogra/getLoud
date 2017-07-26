<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use App\User;

class UserController extends Controller
{

    public function all()
    {
        if (Auth::user() && Auth::user()->type!='Admin') {
            return view('not-authorized');
        }
        $all_users = User::all();
        return view('auth/all', compact('all_users'));
    }

    public function login()
    {
        return view('auth/login');
    }

    public function postLogin(Request $request)
    {
        if(!Auth::attempt($request->only('email', 'password'))) {
            return redirect(action('UserController@login'));
        }
        //TODO redirect admin or business User
        if (Auth::user()->type=='Admin') {
            return redirect(action('UserController@all'));
        }
        return Auth::user();
    }

    public function logout()
    {
        Auth::logout();
        return redirect(action('UserController@login'));
    }

    public function register()
    {
        return view('auth/register');
        return redirect(action('UserController@login'));
    }

    public function postRegister(Request $request)
    {
        $new_user = new User();
        $new_user->name = $request->name;
        $new_user->email = $request->email;
        $new_user->password = Hash::make($request->password);
        $new_user->type = $request->type;
        $new_user->save();
        return $new_user;
    }

    public function delete(Request $request) {
        User::where('id', $request->id)->where('email', $request->email)->delete();
    }

}
