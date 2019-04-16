//Express initializes app
var app = require('express')();
//Express initializes app to be a function handler that you can supply to an HTTP server
var server = require('http').Server(app);
// Notice that I initialize a new instance of socket.io by passing the server (the HTTP server) object.
var io = require('socket.io')(server);
//We make the http server listen on port 3000.
server.listen(8080);
//We define a route handler / that gets called when we hit our website home.
// app.get('/',function(request, response){
//     //response.send('Jay Swaminarayan');
//     //Let’s refactor our route handler to use sendFile
//     //response.sendFile(__dirname + '/index.html');
// });

io.on('connection', function(socket){
  //console.log('an user connected');
  socket.on('chat_message', function(msg){
       //console.log('message: ' + msg); //get message from user to server
       io.emit('chat_message', msg);// broad cast message to user
     });
     //if user disconnected
  socket.on('disconnect', function(){
    console.log('user disconnected');
  });
});
