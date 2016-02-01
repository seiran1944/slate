/**
 * Created by aris on 2014/12/1.
 */

exports.init = init;

function init(app){
    //http://localhost:3000/qrcode?code=9
    app.get( '/qrcode', function(request, response){
            var code = request.query.code;
            code = code ? code : 0;

            var QRCode = require('qrcode');
            QRCode.toDataURL( code ,function(err,url){
                //console.log(typeof(url));
                var DB = require('./DB.js');
                DB.saveQrcode( code, url );

                response.end("<!DOCTYPE html/><html><head><title>qrcode</title></head><body><p >qrcode</p><img src='"+url+"'/></body></html>");
            });
            //readAsDataURL(img)   => url (base64 String)
        }
    );


    app.get( '/login', function(request, response){
            response.render('login');
        }
    )


    app.get( '/loginCheck', function(request, response){
            //response.render('login');
            var code = request.query.code;
            var base64Text = request.query.qrcode;

            if( !code || !base64Text){
                response.send('no input');
                return;
            }

            var DB = require('./DB.js');
            DB.readQrcode(code, hasResult);

            //response.end('Qoo');
            function hasResult(resultCode, resultQrcode){

                if( resultQrcode != false ){
                    console.log('DB has Result');

                    var verify = require('./qrcodeVerification');
                    var resultTxt = verify.compare(base64Text, resultQrcode) ? 'Success' : 'Fail';

                    response.send(resultTxt);//for ajax

                    //response.send(base64Text + '\n' + resultQrcode );
                }else{
                    console.log('DB has no Result');
                    response.send('Fail');
                }
            }

        }
    )
}//end function init