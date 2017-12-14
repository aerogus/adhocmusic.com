// bouton fb login clicked
// et retour d'identification FB ou d'autorisation d'app
function checkLoginState() {
  console.log('checkLoginState (btn clicked)');
  FB.getLoginStatus(function (response) {
    if (response.status === 'connected') {
      console.log('loggué à FB et app');
      FB.api('/me', function (response) {
        console.log(response);
      });
    } else if (response.status === 'not_authorized') {
      console.log('loggué à FB mais par à l app');
    } else {
      console.log('non loggué à FB');
    }
  });
}

window.fbAsyncInit = function() {

  FB.init({
    appId   : '50959607741',
    cookie  : true,
    xfbml   : true,
    version : 'v2.7'
  });

  // le sdk chargé, on check l'authentification direct
  FB.getLoginStatus(function (response) {
    console.log('FB.getLoginStatus');
    console.log(response);
  });

};

(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = '//connect.facebook.net/fr_FR/sdk.js';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
