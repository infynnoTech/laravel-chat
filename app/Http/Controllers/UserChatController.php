<?php

namespace App\Http\Controllers;

use App\User;
use App\UserChat;
use Illuminate\Http\Request;
use Redis;
use Auth;


class UserChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendMessage(Request $request)
    {
        //print_r($request->all());
        $chat = new UserChat();
        if(isset($request->message) && !empty($request->message) && isset($request->user) && !empty($request->user)){
            $getReceiver=User::find($request->user);
            $chat->sender_id=Auth::user()->id;
            $chat->receiver_id=$request->user;
            $chat->message=$request->message;
            $chat->save();
        //    echo $chat->created_at;
        // created redis connection object
            $redis = Redis::connection();
            //pushed all data to array that will send to redis channel
            $data = ['message' => $request->message, 'receiver_name' => $getReceiver->name,'sender_name' => Auth::user()->name,'sender_id'=>Auth::user()->id,'receiver_id'=>$request->user,'date'=>date('M d',strtotime($chat->created_at)),'time'=>date('H:i A',strtotime($chat->created_at))];
            // passed data as json to redis channel
		   $redis->publish('message', json_encode($data));
            return response()->json($data);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\user_chat  $user_chat
     * @return \Illuminate\Http\Response
     */
    public function show(user_chat $user_chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\user_chat  $user_chat
     * @return \Illuminate\Http\Response
     */
    public function edit(user_chat $user_chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\user_chat  $user_chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user_chat $user_chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user_chat  $user_chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(user_chat $user_chat)
    {
        //
    }
}
