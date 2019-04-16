<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserChat extends Model
{
    protected $table = 'user_chats';

    protected $fillable = ['sender_id', 'receiver_id', 'message','created_at','updated_at'];

    public function sender()
    {
       return $this->belongsTo('App\User','sender_id');
    }
    public function receiver()
    {
       return $this->belongsTo('App\User','receiver_id');
    }
}
