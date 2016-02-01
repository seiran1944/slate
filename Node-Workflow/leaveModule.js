var path = require('path');
var fs = require('fs');
var Factory = require('wf').Factory;
var aWorkflow = require('./leave_permission-workflow');

aWorkflow.name = 'leave_permission wf';

exports.startWorkFlow = startWorkFlow;
function startWorkFlow(form) 
{
    var config_file = path.normalize(__dirname + '/config.json');
    fs.readFile(config_file, 'utf8', function (err, data) {
        if (err) {
            throw err;
        }

        var config = JSON.parse(data),
            backendClass = require(config.backend.module),
            var backend = new backendClass(config.backend.opts),
            factory;

            backend.init(function () {
            factory = Factory(backend);
            factory.workflow(aWorkflow, function (err, wf) {

                //add new job to workflow
                var aJob = {
                    workflow: wf.uuid,
                    form: JSON.parse(form)
                };

                factory.job(aJob, function (err, job) {
                    console.log(job);
                });
            });
        });
    });
}
