/**
 * Created by aris on 2014/12/1.
 */
exports.init = init;

function init(app){

    var passport = require('passport');
    app.use(passport.initialize());

    var GoogleStrategy = require('passport-google-oauth').OAuth2Strategy;
    var appRedirectUrl = '/oauthLogged';

    passport.use(new GoogleStrategy({
            clientID: '526363180046-iuf9mtfatdjk52op3g4i72k3k696uaro.apps.googleusercontent.com',
            clientSecret: 'N6gfHEULXmJzOp9fBlcCXTos',
            callbackURL: 'http://localhost:3000'+appRedirectUrl
        },
        function(accessToken, refreshToken, profile, done) {
            User.findOrCreate({ googleId: profile.id }, function (err, user) {
                return done(err, user);
            });
        }
    ));



    app.get('/oauthLogin',
        passport.authenticate('google', { scope: ['https://www.googleapis.com/auth/userinfo.profile',
                                                  'https://www.googleapis.com/auth/userinfo.email'] })
        ,
        function(req, res){
            // The request will be redirected to Google for authentication, so this
            // function will not be called.
        }
    );

    //Note : this url is registered on the google developer , do not tamper
    app.get( appRedirectUrl, function(request, response){
            //response.end('Logged');
            response.redirect('/gmap');
        }
    )

    app.get( '/oauthLogout', function(request, response){
            request.logout();
            response.redirect('/oauthLogin');
        }

    );

}

function ensureAuthenticated(req, res, next) {
    if (req.isAuthenticated()) { return next(); }
    res.redirect('/oauthLogin');
}