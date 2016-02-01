/**
 * Created by aris on 10/6/14.
 */

function log(pathname, params) {
    console.log("log has been called !!");

    var request = params["request"];
    var response = params["response"];

    //msg
    var filereadContent = readLog( writeLog(request) );
    response.write("\nfileread Content : \n" + "<pre>" + filereadContent + "</pre>");
    response.end();
    return filereadContent;//beware of async returns    //node.js rules
}

function writeLog(request){
    var fileSystem = require("fs");
    var util = require('util');

    var today = new Date();
    var fileType = ".log";
    var filePath = "/var/log/node/" + today.getFullYear() + "_" + (today.getMonth() + 1) + "_" + today.getDate() + fileType;

    var appendString = util.inspect(request, true) + "\n" + "==========================" +"\n\n";
    /*//async
    fileSystem.appendFile(filePath, appendString, function (error) {
            if (error) {
                console.log("appendFile Error");
            } else {
                console.log("appendFile succeed");
            }
        }
    );
    */

    //sync
    try{//error proof if sync process goes wrong
        fileSystem.appendFileSync(filePath, appendString);//should beware of error
    }catch(err){
        console.log("appendFile Error");
    }

    return filePath;
}

function readLog( filePath ){
    var fileSystem = require("fs");
    //dump log file
    var logMsg = "default";//for test
    /*//async
    fileSystem.readFileSync(filePath, function (error, fileData) {
            if (error) {
                console.log("Data Read Error");
                logMsg =  "Data Read Error";
            }else{
                console.log("Data Read succeed : ");
                logMsg += fileData;
                //response.write("content : \n" + logMsg);
                //response.end();
            }
        }
    );
    */

    //sync
    try{//error proof if sync process goes wrong
        console.log("Read File succeed");
        logMsg = fileSystem.readFileSync(filePath);
    }catch(err){
        logMsg = err;
        console.log("Data Read Error");
    }

    return logMsg;
}

exports.log = log;

