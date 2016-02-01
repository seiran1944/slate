/**
 * Created by aris on 2014/10/21.
 */
module.exports = Drive;
function Drive(){
    console.log( 'new Drive ' );
    this.CLIENT_ID = '526363180046-iuf9mtfatdjk52op3g4i72k3k696uaro.apps.googleusercontent.com';
    this.CLIENT_SECRET = 'N6gfHEULXmJzOp9fBlcCXTos';
    //this.REDIRECT_URL = 'https://developers.google.com/oauthplayground';//https://developers.google.com/oauthplayground
    this.REDIRECT_URL = require('../config/sys.config.js').localAddress + '/DriveManager/list';

    this.ENDPOINT_OF_GDRIVE = 'https://www.googleapis.com/drive/v2';

    this.google = require('googleapis');
    this.OAuth2Client = this.google.auth.OAuth2;
    this.plus = this.google.plus('v1');

    this.oauth2Client = new this.OAuth2Client(this.CLIENT_ID, this.CLIENT_SECRET, this.REDIRECT_URL);
    this.google.options({ auth: this.oauth2Client });

    this.drive = this.google.drive({version: 'v2'});//, auth: oauth2Client
}
/**
 * extends MODEl ----> CommonModel
 * no DB is needed
 */
//var CommonModel = require('./common.model.js');
//Drive.prototype = new CommonModel;

/**
 *properties
 */
//var thisClass = Drive.prototype;
/*const CLIENT_ID = '526363180046-iuf9mtfatdjk52op3g4i72k3k696uaro.apps.googleusercontent.com';
const CLIENT_SECRET = 'N6gfHEULXmJzOp9fBlcCXTos';
const REDIRECT_URL = 'https://developers.google.com/oauthplayground';//https://developers.google.com/oauthplayground
//const REDIRECT_URL = require('../config/sys.config.js').localAddress + '/DriveManager/list';

const ENDPOINT_OF_GDRIVE = 'https://www.googleapis.com/drive/v2';

var google = require('googleapis');
var OAuth2Client = google.auth.OAuth2;
var plus = google.plus('v1');

var oauth2Client = new OAuth2Client(CLIENT_ID, CLIENT_SECRET, REDIRECT_URL);
google.options({ auth: oauth2Client });

var drive = google.drive({version: 'v2'});//, auth: oauth2Client*/


/**
 * google drive logins
 * @param params
 * @param callback
 */
Drive.prototype.loginGoogleDrive = function(REDIRECT_URL){
    //this.insert(this.table, params, callback);
    //return 'sucess';
    console.log( 'loginGoogleDrive' );

   /*   //141027
    var google = require('googleapis');
    var OAuth2Client = google.auth.OAuth2;
    //var plus = google.plus('v1');

    var oauth2Client = new OAuth2Client(CLIENT_ID, CLIENT_SECRET, REDIRECT_URL);
    google.options({ auth: oauth2Client });
    */

    var url = this.oauth2Client.generateAuthUrl({
        access_type: 'online', // will return a refresh token
        scope: 'https://www.googleapis.com/auth/drive' // can be a space-delimited string or an array of scopes
    });

    return url;

    //return 'I still miss you , Sunny';
}

Drive.prototype.getToken = function(authCode, callback){
    console.log( 'getCode : ' + authCode );
    /*
    var GoogleTokenProvider = require("refresh-token").GoogleTokenProvider;
    var tokenProvider = new GoogleTokenProvider({
        'refresh_token': REFRESH_TOKEN,
        'client_id': CLIENT_ID,
        'client_secret': CLIENT_SECRET
    });
    tokenProvider.getToken();
    */
    var accessToken = null;

      //141027
    var google = require('googleapis');
    var OAuth2Client = google.auth.OAuth2;
    var plus = google.plus('v1');

    var oauth2Client = new OAuth2Client(this.CLIENT_ID, this.CLIENT_SECRET, this.REDIRECT_URL);
    google.options({ auth: oauth2Client });


    oauth2Client.getToken(authCode, function(err, tokens) {
        // Now tokens contains an access_token and an optional refresh_token. Save them.
        accessToken = tokens;
        if(!err) {
            oauth2Client.setCredentials(tokens);
        }
        //callback( accessToken, oauth2Client );
        callback( accessToken, oauth2Client );
    });

    return accessToken;

}

Drive.prototype.getCatalog = function(accessToken, oauth2Client, callback){
    //141027
    var google = require('googleapis');
    var drive = google.drive({ version: 'v2' });//, auth: oauth2Client


    console.log('requesting catalog !! ');
    /*  //for test
    console.log(oauth2Client);
    for( var i in oauth2Client ){
        console.log( i + " = " + oauth2Client[i] );
    }
    */

    this.drive.files.list(
        {
            //'pageToken':accessToken,
            'auth':oauth2Client//,
            /*parm:
            {
                'pageToken':tokens.access_token
                //'auth':oauth2Client
            }*/
        }
        ,
        function(err, body){
            (err) ? console.log('An error occured : ', err) : callback( body );
        }
    );
    //-------------different ways
    //save into cookie as temporary value
    //for(var index in accessToken){
    //this.req.cookie('gDriveCookie', accessToken);//this.CONFIG.gDriveCookieTag
    //res.cookie( this.CONFIG.gDriveCookie, 'accessToken', accessToken );

    /*res.writeHead(200, {
     'Set-Cookie': accessToken,
     'Content-Type': 'text/html'
     });*/

    //}
    /*const ENDPOINT_OF_GDRIVE = 'https://www.googleapis.com/drive/v2';
     var request = require('request');
     request.get({
     'url': ENDPOINT_OF_GDRIVE,
     'qs': {
     'access_token': accessToken
     }
     }, function(err, response, body) {
     *//*body = JSON.parse(body);
     cback(null, {
     'title': body.title,
     'md5Checksum': body.md5Checksum
     });*//*
     console.log(body);
     });*/

    /*var googleDrive = require('google-drive')

    googleDrive(accessToken).files().get(onRespond);

    //https://github.com/niftylettuce/node-google-drive
    function onRespond(err, response, body) {
        //if (err) return console.log('err', err)
        //console.log('response', response);
        console.log('body', JSON.parse(body));
        //callback(JSON.parse(body));
    }*/


}


Drive.prototype.deleteFile = function(deleteFileId, oauth2Client, callback) {
    /*var google = require('googleapis');
    var drive = google.drive({version: 'v2'});//, auth: oauth2Client*/

    console.log('--------deleting file !! ');
    /*  //for test
     console.log(oauth2Client);
     for( var i in oauth2Client ){
     console.log( i + " = " + oauth2Client[i] );
     }
     */

    this.drive.files.trash(
        {
            //'pageToken':accessToken,
            auth: oauth2Client,
            fileId: deleteFileId
        },
        function (err) {
            (err) ? console.log('An error occured : ', err) : null;
        }
    );

    callback();
}


Drive.prototype.uploadFile = function(file, oauth2Client, callback) {
    /*var google = require('googleapis');
     var drive = google.drive({version: 'v2'});//, auth: oauth2Client*/

    console.log('uploading file !! ');
    var formidable = require('formidable');
    var form = new formidable.IncomingForm();

    /*  //for test
     console.log(oauth2Client);
     for( var i in oauth2Client ){
     console.log( i + " = " + oauth2Client[i] );
     }
     */

    this.drive.files.insert(
        {
            //'pageToken':accessToken,
            auth: oauth2Client,
            resource: {title: file.name},
            media: {body: fs.createReadStream(files.upload.path)}
        }

    );
}