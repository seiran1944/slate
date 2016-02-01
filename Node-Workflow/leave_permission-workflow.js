var restify = require('restify');
var fs = require("fs");
var util = require('util');

var workflow = module.exports = {
    name: '' ,

    chain: [ {
        name: 'LeaderApprove',
        timeout: 3,
        retry: 1,
        body: function (job, cb) {
            var client = restify.createJSONClient({
                url: 'http://127.0.0.1:3000'
            });
            return client.get('/leader', function (err, req, res, obj) {
                            var data = JSON.parse(job.form);
                                data.verifiedBy = obj.leaderName;
                                data.comment = obj.comment;
                                data.approve = obj.approve;
                            job.form = JSON.stringify(data);

                            return obj.approve == "true" ? cb(null, 'approved') : cb('wait', 'denied');
                        }
                    );
        }
    }, {
        name: 'HrConfirm',
        timeout: 6,
        retry: 2,
        body: function (job, cb) {
            var client = restify.createJSONClient({
                url: 'http://127.0.0.1:3000'
            });
            return client.get('/sendToHr', function (err, req, res, obj) {
                    var data = JSON.parse(job.form);
                    data.confirmedBy = obj.hrName;
                    job.form = JSON.stringify(data);

                    return cb(null, 'HR confirmed');
                }
            );
        },
    } , {
        name: 'CaseClose',
        timeout: 6,
        retry: 2,
        body: function (job, cb) {
            var client = restify.createJSONClient({
                url: 'http://127.0.0.1:3000'
            });
            return client.get('/readyForClose', function (err, req, res, obj) {
                    var data = JSON.parse(job.form);
                    data.closeDate = obj.closeDate;
                    job.form = JSON.stringify(data);

                    //write to txt
                    var filePath = "/var/www/html/Aris/Workflow/example/log/permission.txt";

                    var appendString = '';
                    for( _index in data ){
                        appendString += _index + ':' + data[_index] + ' , ';
                    }
                    appendString += '\n';

                    console.log(appendString);
                    try{//error proof if sync process goes wrong
                        fs.appendFileSync(filePath, appendString);//should beware of error
                    }catch(err){
                        console.log("appendFile Error");
                    }

                    return cb(null, 'CaseClosed');
                }
            );
        },

    }],
    timeout: 180,
    onerror: [ {
        name: 'Error handler',
        body: function (job, cb) {

        }
    }]
};
