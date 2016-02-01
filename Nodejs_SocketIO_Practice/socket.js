/**
 * Created by aris on 10/7/14.
 */

const socketListenPort = 8080;

function start(io, pathname, params){

    var request = params["request"];
    var response = params["response"];

    //var io = require('socket.io').listen(socketListenPort);
    initSocketResponders(io, params);

    //open html files
    var fileSystem = require("fs");
    var filePath = __dirname + '/socket.html';//pathname;

    //sync
    try{//error proof if sync process goes wrong
        var html = fileSystem.readFileSync(filePath);
        response.write(html, "utf8");
    }catch(err){
        console.log("socket corrupted");
    }
    console.log("socketStart");
    //response.end();
    return html;
}

function initSocketResponders(io, params){
    //var request = params["request"];
    //var response = params["response"];

    io.sockets.on('connection', onConnect);

    function onConnect(socket){
        console.log("socket connected !");

        const INIT_MSG = 'Connected to Server @ ' + new Date();// + ' ::: ' + socket.id;
        const BREAK_UP_MSG = 'Server is going to break this socket in 10 secs';

        socket.emit('connected', {'message' : INIT_MSG});

        socket.on('message', function(data){
                                //response.write('Connected to Server @ ' + new Date() + ' ::: ' + socket.id);
                                var count = data['count'];
                                console.log("message recived : " + count);

                                    if(typeof(count)=='number') {//when > 3 will become BREAK_UP_MSG:String
                                        count++;
                                        if( count >= 3 ){
                                            data['count'] = BREAK_UP_MSG;
                                            data['shutDownClock'] = 10;
                                            socket.emit('shutDown', data);//return secs
                                            setTimeout(function(){socket.disconnect();}, 10500);//disconnect client in 10 secsx
                                        }else{
                                            data['count'] = count;
                                            socket.emit('messageRecived', data);
                                        }
                                    }

                             }
        );

        socket.on('disconnect', function(){
                                    console.log("socket disconnected !");
                                }
        );
        //response.end();

    }

}



exports.start = start;