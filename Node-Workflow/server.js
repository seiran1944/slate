/**
 * Created by aris on 2014/11/26.
 */
var http = require('http');
var express = require('express');
var app = express();
var server = http.createServer(app);

app.set('view engine', 'ejs');


app.get('/',function(request, response){
    response.send('1234567');
    //response.end('hello！');
});


app.get('/leave',function(request, response){
    var form = {'name':'', 'date':'', 'plot':'', 'applyDate':new Date() };
    form.name = request.query.name;
    form.date = request.query.date;
    form.plot = request.query.plot;
    //response.send('form delivered');
    response.end('form delivered！');
    require('./leaveModule.js').startWorkFlow(JSON.stringify(form));

});


var cache = null;
//for workflow
app.get('/leader',function(request, response){

    function OK(leaderName , comment, approve){
        response.send(
            JSON.stringify({
                leaderName: leaderName,
                comment: comment,
                approve: approve
            })
        );
        response.end();
    }
    cache = OK;

});

//for workflow
app.get('/sendToHr',function(request, response){
    function confirm(hrName ){
        response.send(
            JSON.stringify({
                hrName: hrName
            })
        );
        response.end();
    }
    cache = confirm;
});

//for workflow
app.get('/readyForClose',function(request, response){
    function caseClose(){
        response.send(
            JSON.stringify({
                closeDate: new Date()
            })
        );
        response.end();
    }
    cache = caseClose;
});


app.get('/approve',function(request, response){
    if( cache ){
        cache( request.query.leaderName , request.query.comment , request.query.approve );
        cache = null;
    }
    //cache.end();
    response.send('OK : ' + request.query.approve);
});



app.get('/hrConfirm',function(request, response){
    if( cache ){
        cache( request.query.name );
        cache = null;
    }
    //cache.end();
    response.send('confirmed');
});


app.get('/caseClose',function(request, response){
    if( cache ){
        cache();
        cache = null;
    }
    //cache.end();
    response.send('Case Closed');
});


server.listen(3000,'127.0.0.1',function(){
    console.log('server started');
});