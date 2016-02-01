/**
 * Created by aris on 2014/12/1.
 */
var md5 = require('MD5');

exports.compare = compare;
function compare( qrcode1 , qrcode2 ){

    qrcode1 = standardize(qrcode1);
    qrcode2 = standardize(qrcode2);
    /*console.log('====+++++++++++');
    console.log(qrcode1);
    console.log('====+++++++++++');
    console.log(qrcode2);
    console.log('====+++++++++++');*/
    return ( qrcode1 == qrcode2 );
}

function standardize(qrcode){
    //there are better ways , 'match' 'search' , but somehow they don't work
    var tempStr=qrcode;
    do{
        qrcode = tempStr;
        tempStr = tempStr.replace('+', ' ');
    }while(qrcode != tempStr)

    return md5(qrcode);
}