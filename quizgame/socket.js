var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var Redis = require('ioredis');
var redis = new Redis();
redis.subscribe('join-players', 'new-player', 'game-finished', function(err, count) {});
redis.on('message', function(channel, message) {
	var today = new Date()
	today.setHours(today.getHours() - 1)
	today = today.toLocaleString();
    console.log('Message Recieved: ' + message + ' ' + today);
    message = JSON.parse(message);
    io.emit(channel + ':' + message.event, message.data);
});
http.listen(8080, function(){
    console.log('Listening onijojio Port ' + http.address().address + ':' + http.address().port);
});