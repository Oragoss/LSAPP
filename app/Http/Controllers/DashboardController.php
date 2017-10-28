<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //Because of the relationship we defined in the Post and User models, we
      //can simply tell this controller to grab all of the posts associated with
      //the user currently logged in (the $auth->user() part).
      $user_id = auth()->user()->id;
      $user = User::find($user_id); //Using the User model we can find the user with the id they are logged in with
      return view('dashboard')->with('posts', $user->posts);
    }
}
