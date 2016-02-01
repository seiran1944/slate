/**
 * Created by aris on 2014/10/13.
 */
//===========================================configuration
/*
 *Achtung : Avoid using phone verification or others for your google account
 *          ,API won't work with it.(XMPP Authentication failure)   --Aris stuck here for two days...
 *          Make sure your account login is simple and pure.
 *
 *          #For receiving the message from test program,
 *          friendship bound for each other is also required.
 *
 *          2014/10/15  Aris noted
 */
//----for inputs   
var argv = process.argv;
console.log(argv);
if (argv.length != 6) {
    console.log('Usage: nodejs xmpp.js <sender-jid> <sender-password> <recipent-jid> <msg>');
    process.exit(1);
}
const jid = argv[2];
const password = argv[3];
const recipientJid = argv[4];
const msg = argv[5];

/*
 //----for test
const jid = 'arisaka1940@gmail.com';//this is a new account for testing , simple login.
const password = 'password';

const recipientJid = 'mengiunlo@gmail.com';//'mengiunlo@gmail.com';
const msg = 'test message , from : ' + jid + ' via node.js & node-xmpp';
*/

//configuration info should be tear to an isolated file. Here just for quick using.
const config = {
    jid         : jid,
    password    : password,
    preferred   : 'PLAIN',
    host        : 'talk.google.com',
    //host        : 'talkx.l.google.com',
    port        : 5222,//c2s     //5269 : s2s
}
//==================================END======configuration

//===========================================Main
const xmpp = require('node-xmpp');
console.log('connetcting......');
const connection = new xmpp.Client(config);

//connection.on('online', request_google_roster);
connection.on('stanza', traceStanza);//makind friend
connection.on('online', onConnected);
connection.on('error', onError);
//================================END========Main

//===============================================Event Responders
function onConnected(data){
    console.log('online : ');
    console.log('Connected as ' + data.jid.user + '@' + data.jid.domain + '/' + data.jid.resource)
    sendMessage( recipientJid , msg );
    //process.exit(1);
}

function onError(error){
    console.log('Error : ' + error);
}
//====================================END========Event Responders

//===============================================Actions
function sendMessage(recipientJid, message_body) {
    var elem = new xmpp.Element('message', { to: recipientJid, type: 'chat' })
        .c('body').t(message_body);
    connection.send(elem);
    console.log('[message] SENT: ' + elem.up().toString());
}



//-----------for test
function request_google_roster() {
    var rosterElem = new xmpp.Element('iq', { from: connection.jid, type: 'get', id: 'google-roster'})
        .c('query', { xmlns: 'jabber:iq:roster', 'xmlns:gr': 'google:roster', 'gr:ext': '2' });
    connection.send(rosterElem);
    console.log('\n rosterElem : ----------------------\n' + rosterElem + '\n');
}

function traceStanza(stanza) {
    console.log('\nstanza : ----------------------\n' + stanza + '\n');
    if(stanza.type === 'error') {
        console.log('--error recived : ');
        traceObjectDepth( stanza.attrs );
    }
}

function traceObjectDepth(object){
    if(typeof object != 'object'){
        console.log('\n' + object);
        return;
    }

    var currentVar = null;
    for (var attrs in object){
        currentVar = object[attrs];
        ( typeof currentVar == 'object' ) ? traceObjectDepth(currentVar) : console.log('\n' + attrs + ' : ' + currentVar);
    }
}
//=================================END===========Actions