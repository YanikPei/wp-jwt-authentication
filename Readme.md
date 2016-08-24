# WordPress Authentication Kit

Makes it possible to login to your WordPress backend and Rest API via social networks.

* Login via Account Kit (Phone and Email)
* Login via Facebook
* Authenticate to your WP Rest API via JSON Web Tokens, Facebook and AccountKit

![Login](http://ypeiffer.com/wp-content/uploads/2016/04/Bildschirmfoto-2016-04-24-um-14.25.09.png)

## Requirements

* WordPress 4.4 or higher

## Installation

* Download the latest version.
* Upload the entire folder to the /wp-content/plugins/ directory.
* Activate the plugin
* Go to `Settings -> Authentication Kit` and create a secret

### Login via facebook

[Wiki: Set up Facebook](https://github.com/YanikPei/wp-jwt-authentication/wiki/Set-up-Facebook)

### Login via AccountKit

[Wiki: Set up AccountKit](https://github.com/YanikPei/wp-jwt-authentication/wiki/Set-up-AccountKit)

## WP Rest API

### What are JSON-Web-Tokens

> JSON Web Tokens are an open, industry standard RFC 7519 method for representing claims securely between two parties.

[More on JWT](https://jwt.io/)


### Authenticate via username and password

In order to get a token for a user, you have to make a GET-request to this endpoint by passing a username and password. If the combination is correct you will receive the token and its expiration timestamp.

```
GET http://YOUR_URL/wp-json/wp-jwt/v1/login?username=USERNAME&password=PASSWORD
```
