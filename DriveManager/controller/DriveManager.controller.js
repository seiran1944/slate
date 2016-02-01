/**
 * Created with JetBrains WebStorm.
 * User: Administrator
 * Date: 13-4-22
 * Time: 上午10:23
 * To change this template use File | Settings | File Templates.
 */
module.exports = DriveManagerController;
function DriveManagerController(req, res){
    this.req = req;
    this.res = res;
}

/**
 * 继承自CommonController
 * @type {*}
 */
var CommonController = require('./common.controller.js');
DriveManagerController.prototype = new CommonController();


/**
 * g drive login
 */
DriveManagerController.prototype.loginAction = function(){
    var req = this.req,
        res = this.res,
        thisObj = this;

    var Drive = require(this.CONFIG.MODEL_PATH + '/Drive.model.js');//get model instance
    var DriveModel = new Drive();
    var REDIRECT_URL = DriveModel.REDIRECT_URL;//require('../config/sys.config.js').localAddress + '/DriveManager/list';

    var actionFlag = req.query.action;
    switch (actionFlag){
        case "delete" :
                REDIRECT_URL = require('../config/sys.config.js').localAddress + '/DriveManager/delete';
            break;

        case "upload":
                REDIRECT_URL = require('../config/sys.config.js').localAddress + '/DriveManager/upload';
            break;

        default :
                REDIRECT_URL = REDIRECT_URL;
            break;

    }

    var loginUrl = DriveModel.loginGoogleDrive(REDIRECT_URL);

    console.log('------Connect to google API !! URL = ' + loginUrl);
    //console.log('------Connect to google API !! URL = ');




    return res.redirect(loginUrl);
}

DriveManagerController.prototype.listAction = function(){
    console.log('listing drive catalog');

    var req = this.req,
        res = this.res,
        thisObj = this;

    //http://localhost:3000/DriveManager/list?code=4/uThO3pD1WrN8zaHQP5OApy6jhl4U4v17H4vLApIjSA0.Mt5g5SA1GbMbgrKXntQAax1Sow1ukgI
    //req.query : url of getmethod ,    .code : var behind '?' (code = xx***)   141023
    var code = req.query.code;
    var Drive = require(this.CONFIG.MODEL_PATH + '/Drive.model.js');//get model instance
    var DriveModel = new Drive();
    //const REDIRECT_URL = require('../config/sys.config.js').localAddress + '/DriveManager/list';
    DriveModel.getToken(code,retriveAccessToken);
    //DriveModel.getCatalog(null, null, listContent);
    var tokenPack = null;
    var _oauth2Client = null;

    function retriveAccessToken(tokens, oauth2Client){
        //console.log( tokens );
        //console.log(new Date().getTime());//unix time
        /*Note : accessToken data structure as below
            { access_token: 'ya29.pwB8iPUYLDLlFoHMhFJhiOaWRBZnIxTL5FZn-tlhP4tt7H4gEJRbMbZgZBdOx3BCq7e2lM4H-JY07A',
            token_type: 'Bearer',
            expiry_date: 1414049996364 }
        */
        //save token to session //http://fred-zone.blogspot.tw/2011/11/nodejs-express-cookie-based-session.html
        req.session = { 'dDriveToken': tokens.access_token , 'oauth2Client':oauth2Client };
        console.log( 'AccessToken has been retrived !! : ' + tokens.access_token );
        //req.session.dDriveToken   req.session.dDriveToken
        //console.log(oauth2Client);

        tokenPack = tokens;
        _oauth2Client = oauth2Client;
        DriveModel.getCatalog(tokens.access_token, oauth2Client, listContent);
    }

    function listContent(body){
        //console.log(body);
        /*//===========data struct like this :
        { kind: 'drive#fileList',
         etag: '"lHp9sVndhdVrqRbdRzOZyxWEg4U/X1AIOWWiInJTcf8INZfwjLc3-G0"',
         selfLink: 'https://www.googleapis.com/drive/v2/files',
         items:
         [ { kind: 'drive#file',
         id: '0B0T9LcKK4U3DVThrRzNtN0ZZdE0',
         etag: '"lHp9sVndhdVrqRbdRzOZyxWEg4U/MTQxNDA1NDQyNzIwNA"',
         selfLink: 'https://www.googleapis.com/drive/v2/files/0B0T9LcKK4U3DVThrRzNtN0ZZdE0',
         webContentLink: 'https://docs.google.com/uc?id=0B0T9LcKK4U3DVThrRzNtN0ZZdE0&export=download',
         alternateLink: 'https://docs.google.com/file/d/0B0T9LcKK4U3DVThrRzNtN0ZZdE0/edit?usp=drivesdk',
         iconLink: 'https://ssl.gstatic.com/docs/doclist/images/icon_10_pdf_list.png',
         thumbnailLink: 'https://lh5.googleusercontent.com/PctsbpokBKk93XHMvNYZXY1vTDYv4s7wde899ZtxQ4wdaBDPGWmuZqvRalntdAvOUg_3YQ=s220',
         title: 'Rework.pdf',
         mimeType: 'application/pdf',
         labels: [Object],
         createdDate: '2014-10-23T08:53:47.204Z',
         modifiedDate: '2014-10-23T08:53:47.204Z',
         modifiedByMeDate: '2014-10-23T08:53:47.204Z',
         markedViewedByMeDate: '1970-01-01T00:00:00.000Z',
         version: '63',
         parents: [Object],
         downloadUrl: 'https://doc-00-40-docs.googleusercontent.com/docs/securesc/jmnajvmfgjaq12v5ft4enoj8ibc2teiv/3smh9ois480ejeqlbl4k0k15qkrls1ne/1414058400000/13058876669334088843/14458727793837306056/0B0T9LcKK4U3DVThrRzNtN0ZZdE0?e=download&gd=true',
         userPermission: [Object],
         originalFilename: 'Rework.pdf',
         fileExtension: 'pdf',
         md5Checksum: 'a619f79e0c6e47e362766714ab66aa77',
         fileSize: '3523083',
         quotaBytesUsed: '3523083',
         ownerNames: [Object],
         owners: [Object],
         lastModifyingUserName: 'Aris Chen',
         lastModifyingUser: [Object],
         editable: true,
         copyable: true,
         writersCanShare: true,
         shared: false,
         appDataContents: false,
         headRevisionId: '0B0T9LcKK4U3DZ3VjcU4rVWE2TW11VU1JbjBSbENJeVFsZlFJPQ' },
         ]
         }
         */
        //return res.render('DriveManager_List',{title:'Google Drive Files ', gDriveToken:'gggg', content:body, code:code});
        return res.render('DriveManager_List',{title:'Google Drive Files ', gDriveToken:tokenPack, content:body, code:code, oauth2Client:_oauth2Client});
    }



}

DriveManagerController.prototype.deleteAction = function() {
    console.log('deleting drive file');

    var req = this.req,
        res = this.res,
        thisObj = this;

    //http://localhost:3000/DriveManager/list?code=4/uThO3pD1WrN8zaHQP5OApy6jhl4U4v17H4vLApIjSA0.Mt5g5SA1GbMbgrKXntQAax1Sow1ukgI
    //req.query : url of getmethod ,    .code : var behind '?' (code = xx***)   141023
    //var code = req.query.deleteId;
    var deleteFileId = req.query.deleteId;
    console.log( 'deleteFileId = ' + deleteFileId );
    //var Drive = require(this.CONFIG.MODEL_PATH + '/Drive.model.js');//get model instance
    //var DriveModel = new Drive();
    const REDIRECT_URL = require('../config/sys.config.js').localAddress + '/DriveManager/login';
    //DriveModel.getToken(code, retriveAccessToken, REDIRECT_URL);
    //console.log('+++++++++++++++++');
    //console.log(req.session.oauth2Client);
    //console.log('-----------------');
    //DriveModel.deleteFile(deleteFileId, req.session.oauth2Client, callBack);

    //return res.redirect(REDIRECT_URL);


    var google = require('googleapis');
    var drive = google.drive('v2');

    //redo and simulate original object type
    var cacheOauth2Client = req.session.oauth2Client;
    var OAuth2Client = google.auth.OAuth2;
    var oauth2Client = new OAuth2Client(cacheOauth2Client.clientId_, cacheOauth2Client.clientSecret_, cacheOauth2Client.redirectUri_);
    google.options({ auth: oauth2Client });
    oauth2Client.setCredentials(cacheOauth2Client.credentials);

    //console.log('fdsfdsfdfdsfds------------------------------------');
    //console.log(drive);
    //console.log('fdsfdsfdfdsfds------------------------------------');
    drive.files.trash({
            auth: oauth2Client,
            fileId: deleteFileId
        },
        function (err, driveFilesList) {
            if (err) {
                console.log('An error occured', err);
            }
            //else {
                res.redirect(REDIRECT_URL);
            //}
        }
        /*function (err, body){
            return res.render('DriveManager_List',{title:'Google Drive Files ', gDriveToken:null, content:body, code:"fdsfs", oauth2Client:oauth2Client});
        }*/
    );


}


DriveManagerController.prototype.uploadAction = function() {
    console.log('uploading file');

    var req = this.req,
        res = this.res,
        thisObj = this;

    //console.log(req.body);
    console.log(req.files);

    //http://localhost:3000/DriveManager/list?code=4/uThO3pD1WrN8zaHQP5OApy6jhl4U4v17H4vLApIjSA0.Mt5g5SA1GbMbgrKXntQAax1Sow1ukgI
    //req.query : url of getmethod ,    .code : var behind '?' (code = xx***)   141023
    var code = req.query.code;
    var deleteFileId = req.query.deleteFileId;

    //var Drive = require(this.CONFIG.MODEL_PATH + '/Drive.model.js');//get model instance
    //var DriveModel = new Drive();
    const REDIRECT_URL = require('../config/sys.config.js').localAddress + '/DriveManager/login';
    //DriveModel.getToken(code, retriveAccessToken, REDIRECT_URL);

    var fs = require('fs');

    //redo and simulate original object type
    var google = require('googleapis');
    var drive = google.drive('v2');

    var cacheOauth2Client = req.session.oauth2Client;
    var OAuth2Client = google.auth.OAuth2;
    var oauth2Client = new OAuth2Client(cacheOauth2Client.clientId_, cacheOauth2Client.clientSecret_, cacheOauth2Client.redirectUri_);
    google.options({ auth: oauth2Client });
    oauth2Client.setCredentials(cacheOauth2Client.credentials);


    console.log("---------------------------------------");

    //console.log(req);
    drive.files.insert({resource: {title: req.files.upload.name},media: {body: fs.createReadStream(req.files.upload._writeStream.path)},auth:oauth2Client});

    return res.redirect(REDIRECT_URL);

}