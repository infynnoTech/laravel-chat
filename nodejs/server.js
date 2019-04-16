//Express initializes app
var app = require('express')();
//Express initializes app to be a function handler that you can supply to an HTTP server
var server = require('http').Server(app);
// Notice that I initialize a new instance of socket.io by passing the server (the HTTP server) object.
var io = require('socket.io')(server);
//redis : used as a database, cache and message broker
var redis = require('redis');
/*
jQuery.eye is a jQuery plugin for monitoring changes made to elements' DOM or CSS properties as well as monitoring changes of the returned results from jQuery methods ran on a given element. When a change is detected a callback function is fired.
https://github.com/Xaxis/jquery.eye
*/
var eyes = require('eyes'),
	https = require('https'),//HTTPS is the HTTP protocol over TLS/SSL. In Node.js this is implemented as a separate module. https://nodejs.org/api/https.html
	fs = require('fs'),//The fs module provides an API for interacting with the file system in a manner closely modeled around standard POSIX functions. https://nodejs.org/api/fs.html
	xml2js = require('xml2js'),//Simple XML to JavaScript object converter. It supports bi-directional conversion
	parser = new xml2js.Parser(); //for xml parsing
	var parseString = require('xml2js').parseString;
//We make the http server listen on port 8080.
server.listen(8080);

io.on('connection', function (socket) {
	//listen on the connection event for incoming sockets, and I log it to the console.
	console.log("client connected");
	var redisClient = redis.createClient(); //connections automatically to redis and this creates a new client
	redisClient.subscribe('message'); //subscribed to a channel which listens for incoming messages

	redisClient.on("message", function(channel, data) {
        console.log(data);
		console.log(channel);
        socket.emit('follownotice', data); // you can send and receive any events you want, with any data you want
	});

	socket.on('disconnect', function() {
		console.log('leaved');// when user close the page  Socket will retuen event descunnected.
	});
});
