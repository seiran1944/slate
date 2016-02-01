/**
 * Created by aris on 10/6/14.
 */
var dbConnetction = null;
function connetcDB(){
    if(dbConnetction){
        return dbConnetction;
    }

    var mysql      = require('mysql');
    dbConnetction = mysql.createConnection({
        host     : '127.0.0.1',
        user     : 'root',
        password : '1234',
        database : 'NodejsDB'
    });

    dbConnetction.connect();

    return dbConnetction;
}

function writeDB(pathname, params){
    console.log("\nwriteDB");

    var connection = connetcDB();
    var request = params["request"];
    var response = params["response"];

    var data = {
        IP : request.connection.remoteAddress,
        User_Agent : request.headers['user-agent']
    };

    console.log('IP : '+ data.IP + '     , User_Agent : '+ data.User_Agent);

    var sql = 'INSERT INTO log SET ?';
    connection.query(sql, data, function(error){
                                    if(error){
                                        console.log('data writting error');
                                        throw error;
                                    }
                                }
    );//end query

    response.end();
    //connection.end();
}

function readDB(pathname, params){
    var connection = connetcDB();
    connection.query('SELECT * FROM log',function(error, rows, fields){
                                            if(error){
                                                throw error;
                                            }

                                            var request = params["request"];
                                            var response = params["response"];
                                            console.log('DB reading !!');
                                            var row = null;
                                            for( var rowIndex in rows ){
                                                row = rows[rowIndex];
                                                for( var index in row ){
                                                    response.write( ' . ' + index + ' : ' + row[index] );
                                                    console.log(' . ' + index + ' : ' + row[index]);
                                                }
                                                response.write( "<br>" );
                                            }
                                            response.end();
                                        }
    );//end query

}

exports.writeDB = writeDB;
exports.readDB = readDB;