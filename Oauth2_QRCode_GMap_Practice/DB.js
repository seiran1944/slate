/**
 * Created by aris on 2014/12/1.
 */
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

var md5 = require('MD5');
function saveQrcode(code, qrCode, callback){
    //code != qrcode   ,  Note : code is the index of the qrcode:base64String
    console.log("\nwriteDB");

    var connection = connetcDB();

    var data = {
        code : code,
        qrcode : qrCode
        //qrcode : md5(qrCode)
    };

    console.log('code : '+ data.code + '     , qrCode : '+ data.qrcode);

    var sql = 'INSERT INTO `qrcode` SET ? ' ;
    connection.query(sql, data, function(error){
            if(error){
                console.log('data writting error');
                throw error;
            }
            callback ? callback() : null;
        }
    );//end query
}


function readQrcode(code, callback){
    //code != qrcode   ,  Note : code is the index of the qrcode:base64String
    var connection = connetcDB();
    console.log('DB reading !!');
    connection.query('SELECT * FROM `qrcode` WHERE code="'+code+'"',function(error, rows, fields){
            if(error){
                throw error;
            }

            var row = {code:-1, qrcode:false};
            for( var rowIndex in rows ){
                row = rows[rowIndex];
                break;
            }
            console.log('code : '+ row.code + '     , qrCode : '+ row.qrcode);
            callback( row.code , row.qrcode );
        }
    );//end query

}


exports.saveQrcode = saveQrcode;
exports.readQrcode = readQrcode;