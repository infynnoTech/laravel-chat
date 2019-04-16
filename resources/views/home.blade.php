@extends('layouts.app')

@section('content')

<div class="container">
<h3 class=" text-center">Messaging</h3>
<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Recent</h4>
            </div>
            <div class="srch_bar">
              <div class="stylish-input-group">
                <input type="text" class="search-bar"  placeholder="Search" >
                <span class="input-group-addon">
                <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span> </div>
            </div>
          </div>
          <div class="inbox_chat">
            @isset($users)
                @foreach($users as $user)
                    <div class="chat_list active_chat" data-user="{{$user->id}}">
                      <div class="chat_people">
                        <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                        <div class="chat_ib">
                          <h5>{{$user->name}} <span class="chat_date">Dec 25</span></h5>
                          <p>User</p>
                        </div>
                      </div>
                    </div>
                @endforeach
            @endisset

          </div>
        </div>
        <div class="mesgs">
            <div class="msg_history">
                @if(isset($users_chat) && !empty($users_chat))
                    @foreach($users_chat as $message)
                        @if($message->receiver_id == Auth::id())
                            <div class="incoming_msg">
                              <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                              <div class="received_msg">
                                <div class="received_withd_msg">
                                    <p><strong>{{$message->sender->name}}</strong></p>
                                  <p>{{$message->message}}</p>
                                  <span class="time_date"> 11:01 AM    |    June 9</span></div>
                              </div>
                            </div>
                        @else
                            <div class="outgoing_msg">
                              <div class="sent_msg">
                                <p>{{$message->message}}</p>
                                <span class="time_date"> 11:01 AM    |    June 9</span> </div>
                            </div>
                        @endif
                    @endforeach
                @endif

            </div>
            <form>
                <div class="type_msg">
                    <div class="input_msg_write">
                        <input type="text" class="write_msg" placeholder="Type a message" />
                        <input type="hidden" name="user" id="user_with" value=""/>
                        <button class="msg_send_btn" type="button">Send</button>
                    </div>
                </div>
            </form>
        </div>
      </div>


      <!-- <p class="text-center top_spac"> Develop by <a target="_blank" href="#">Nikhil Patel</a></p> -->

    </div></div>
@endsection
