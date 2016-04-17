function fbLoginButton(redirect) {
  FB.login(function(response) {

    window.location.href = redirect + '&token=' + response.authResponse.accessToken;

  }, {scope: 'public_profile,email'});
}
