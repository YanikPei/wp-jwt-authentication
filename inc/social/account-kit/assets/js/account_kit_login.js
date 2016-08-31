// login callback
var account_kit_redirect = '';

function loginCallback(response) {

  if (response.status === "PARTIALLY_AUTHENTICATED") {

    window.location.href = account_kit_redirect + '&token=' + response.code;

  }
  else if (response.status === "NOT_AUTHENTICATED") {
    alert('Something went wrong! Please try again.');
  }
  else if (response.status === "BAD_PARAMS") {
    alert('Something went wrong! Please try again.');
  }
}

// phone form submission handler
function phone_btn_onclick(redirect) {
  account_kit_redirect = redirect;
  AccountKit.login('PHONE', {}, loginCallback);
}


// email form submission handler
function email_btn_onclick(redirect) {
  account_kit_redirect = redirect;
  AccountKit.login('EMAIL', {}, loginCallback);
}
