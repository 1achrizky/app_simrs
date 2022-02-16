<!DOCTYPE html>
<html>
    <head></head>
    <body>
        
        <script>
          window.fbAsyncInit = function() {
            FB.init({
              appId      : '',
              cookie     : true,
              xfbml      : true,
              version    : 'v4.0'
            });
              
            FB.AppEvents.logPageView();
            
            // FB.getLoginStatus(function(response) {
            //     statusChangeCallback(response);
            // });
            
            FB.login(function(response) {
                console.log(response);
                if (response.authResponse) {
                 console.log('Welcome!  Fetching your information.... ');
                 FB.api('/me', function(response) {
                   console.log('Good to see you, ' + response.name + '.');
                 });
                } else {
                 console.log('User cancelled login or did not fully authorize.');
                }
            });
              
          };
        
          (function(d, s, id){
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement(s); js.id = id;
             js.src = "https://connect.facebook.net/en_US/sdk.js";
             fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));
          
          //===============
            
          
            
        </script>
        <script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>
        
        <span>FB testing<span>
        
    </body>
</html>