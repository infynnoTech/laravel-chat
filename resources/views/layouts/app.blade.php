<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat_custom.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!--  socket.io front library-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.2.0/socket.io.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.1.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.min.js"></script> -->
    <script>
        $(function(){

            $(".msg_history").animate({ scrollTop: $('.msg_history').prop("scrollHeight")}, 1000);


            // socket initialize and connect to port
            var socket = io.connect('http://localhost:8080');
            //ajax for get message from user and store to data base
             $('.msg_send_btn').click(function(e){
                e.preventDefault();
                //alert('a');
                e.preventDefault();
                var token = $("input[name='_token']").val();
                var user = $("input[name='user']").val();
                var msg = $(".write_msg").val();
                if(msg != ''){
                    $.ajax({
                        type: "POST",
                        url: '{!! URL::to("sendmessage") !!}',
                        dataType: "json",
                        data: {'_token':token,'message':msg,'user':user},
                        success:function(data) {
                            //    alert('b');
                            //    console.log(data);
                            //pass data to socket and it will push to end user
                            socket.on('follownotice',function(data) {

            					data = jQuery.parseJSON(data);
                                //console.log(data);
                                //$('.msg_history').html(data.message);
                                //condition for receiver and sender virew (DESIGN PURPUSE)
                                var uppend = 0;

                                if(uppend == 0) {

                                    if( data.sender_id == {{Auth::id()}} ) {
                                        $('.msg_history').append('<div class="outgoing_msg"><div class="sent_msg"><p>'+data.message+'</p><span class="time_date"> '+data.time+'    |    '+data.date+'</span></div></div>');

                                    } else {
                                        $('.msg_history').append('<div class="incoming_msg"><div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div><div class="received_msg"><div class="received_withd_msg"><p><strong>'+data.sender_name+'</strong><br/>'+data.message+'</p><span class="time_date"> '+data.time+'    |    '+data.date+'</span></div></div></div>');
                                    }

                                    uppend++;
                                }
                                // $(".msg_history").animate({ scrollTop: $('.msg_history').offset().top }, 1000);
                                $(".msg_history").animate({ scrollTop: $('.msg_history').prop("scrollHeight")}, 1000);


        				    });

                            $(".write_msg").val('');
                        }
                    });
                } else {
                    alert("Please Add Message.");
                }

            });

            function chatWithUser(user){
                if(user == 0){
                    var user_id = $('.inbox_chat .chat_list:nth-child(1)').attr('data-user');
                    //alert(user_id);
                    $('#user_with').val(user_id);
                }

            }
            chatWithUser(0);

        });
    </script>
</body>
</html>
