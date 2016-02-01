/**
 * Created by aris on 2014/12/2.
 */
exports.init = init;

function init(app){


    app.get('/gmap', function(request, response) {
            response.render('gmap');
        }
    );





}