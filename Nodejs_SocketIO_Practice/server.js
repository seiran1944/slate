/**
 * Created by aris on 10/6/14.
 */
const servicePort = 3000;
const socketPort = 8080;
var http = require("http");
var url = require("url");
//var EventEmitter = require("events").EventEmitter;

var router = require("./router");

function onRequest(request, response) {
    var pathname = url.parse(request.url).pathname;
    console.log("Request for " + pathname + " received.");

    var dateAndTime = new Date();

    //response.writeHead(200, {"Content-Type": "text/plain"});
    response.writeHead(200, {"Content-Type": "text/html"});
    response.write('Welcome to Nodejs Server : ' + dateAndTime + "<br>");//
    router.route(pathname, {"request" : request , "response" : response});
    //response.end();
}

var server = http.createServer(onRequest).listen(servicePort);

console.log("Server has started.");


//===============================================================socket server
var socketServer = http.createServer(socketRequest).listen(socketPort);
var io = require('socket.io');
var serv_io = io.listen(socketServer);

/*
serv_io.sockets.on('connection', function(socket) {
    socket.emit('message', {'message': 'WTF'});
});
*/

function socketRequest(request, response){
    var fs = require('fs');

    console.log("connected from :8080");
    var socket = require("./socket");
    var pathname = url.parse(request.url).pathname;
    response.writeHead(200, {"Content-Type": "text/html"});
    socket.start(serv_io, pathname, {"request" : request , "response" : response});
    response.end();
}







