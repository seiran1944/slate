/**
 * Created by aris on 10/6/14.
 */
var fileread = require("./fileread");
var database = require("./database");
//var socket = require("./socket");

var routePaths = {
                        "/file" : fileread.log,
                        "/db/write" : database.writeDB,
                        "/db/read" : database.readDB,
                        //"/socket.html" : socket.start,
                        };

function route(pathname, params) {
    console.log("About to route a request for " + pathname);
    var routePath = routePaths[pathname];

    if (typeof routePath === 'function') {
        return routePath(pathname, params);
    } else {
        console.log("No request handler found" + pathname);
        var response = params["response"];
        response.end();
        return "";//No request handler found
    }

}

//exports means outter request , take it as class public method //Aris 141006
exports.route = route;