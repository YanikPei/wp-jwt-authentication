// login callback
function loginCallback(response) {

  if (response.status === "PARTIALLY_AUTHENTICATED") {
    document.getElementById("token").value = response.code;
    document.getElementById("method").value = 'account_kit';
    document.getElementById("loginform").setAttribute("action", "/wp-json/wp-jwt/v1/login");
    document.getElementById("loginform").setAttribute("method", "GET");
    document.getElementById("loginform").submit();
  }
  else if (response.status === "NOT_AUTHENTICATED") {
    alert('Something went wrong! Please try again.');
  }
  else if (response.status === "BAD_PARAMS") {
    alert('Something went wrong! Please try again.');
  }
}

// phone form submission handler
function phone_btn_onclick() {
  AccountKit.login('PHONE', {}, loginCallback);
}


// email form submission handler
function email_btn_onclick() {
  AccountKit.login('EMAIL', {}, loginCallback);
}
