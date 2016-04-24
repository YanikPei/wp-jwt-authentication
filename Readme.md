# JSON-Web-Token for WordPress

Authenticate to WordPress using JSON-Web-Tokens.

* Easy to use authentication methods for WordPress Rest-API and Backend
* Authenticate via username and password
* Authenticate via AccountKit
* Authenticate via Facebook
* Give users the possibility to register/login via email, phone number or facebook

![Login](http://ypeiffer.com/wp-content/uploads/2016/04/Bildschirmfoto-2016-04-24-um-14.25.09.png)


## What are JSON-Web-Tokens

> JSON Web Tokens are an open, industry standard RFC 7519 method for representing claims securely between two parties.

[More on JWT](https://jwt.io/)

## Installation

* Download the latest version.
* Upload the entire folder to the /wp-content/plugins/ directory.
* Activate the plugin
* Go to `settings -> JWT` and create a secret


## Requirements

* WordPress 4.4 or higher


### Authenticate via username and password

In order to get a token for a user, you have to make a GET-request to this endpoint by passing a username and password. If the combination is correct you will receive the token and its expiration timestamp.

```
GET http://YOUR_URL/wp-json/wp-jwt/v1/login?username=USERNAME&password=PASSWORD
```

### Authenticate via facebook

[Wiki: Set up Facebook](https://github.com/YanikPei/wp-jwt-authentication/wiki/Set-up-Facebook)

### Authenticate via AccountKit

[Wiki: Set up AccountKit](https://github.com/YanikPei/wp-jwt-authentication/wiki/Set-up-AccountKit)
