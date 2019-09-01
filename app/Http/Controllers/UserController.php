<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function loginAs()
    {
        //get the id from the post
        $id = request('user_id');
            // dd('dada');

        //if session exists remove it and return login to original user
        if (session()->get('hasClonedUser') == 298) {
            auth()->loginUsingId(session()->remove('hasClonedUser'));
            session()->remove('hasClonedUser');
            // dd('dada1111');
            return redirect()->back();
        }

        //only run for developer, clone selected user and create a cloned session
        if (auth()->user()->id == 298) {
            session()->put('hasClonedUser', auth()->user()->id);
            auth()->loginUsingId($id);
            // dd('dada222');
            return redirect()->back();
        }
    }
}