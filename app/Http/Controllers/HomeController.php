<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\UserChat;

class HomeController extends Controller
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['users']=User::where('id','!=',Auth::user()->id)->get();
        $data['users_chat']=UserChat::where('sender_id','=',Auth::user()->id)->orWhere('receiver_id','=',Auth::user()->id)->get();
        return view('home',$data);
    }
}
