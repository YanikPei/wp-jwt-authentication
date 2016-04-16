# JSON-Web-Token for WordPress

Authenticate to WordPress-Rest-API using JSON-Web-Tokens.


## What are JSON-Web-Tokens

> JSON Web Tokens are an open, industry standard RFC 7519 method for representing claims securely between two parties.

What this quote is trying to say is that JSON-Web-Tokens are super awesome for authenticating to an api
without dealing with OAuth. The server creates a unique token for a user which is sent with every api-request.


## Installation

* Download the latest version.
* Upload the entire folder to the /wp-content/plugins/ directory.
* Activate the plugin through the 'Plugins' menu in WordPress.
* Go to `settings -> JWT` and create a secret


## Requirements

* WordPress 4.4


## Using the plugin

After installing the plugin, a new endpoint is added to your wp-rest-api: `/wp-json/wp-jwt/v1/login`


### Authenticate via username and password

In order to get a token for a user, you have to make a GET-request to this endpoint by passing a username and password. If the combination is correct you will receive the token and its expiration timestamp.

```
GET http://YOUR_URL/wp-json/wp-jwt/v1/login?username=USERNAME&password=PASSWORD
```

### Authenticate via facebook

**First you have to create a [facebook-app](https://developers.facebook.com/docs/apps/register).**

In order to authenticate via facebook, you have to make a GET-request to this endpoint by passing the method and a access-token/code from the facebook login ([developers.facebook.com](https://developers.facebook.com/docs/facebook-login/access-tokens)).
You will receive a JWT to access endpoints that require authorization.

**Make sure to enter the facebook app-id and secrect in plugins settings.**

```
GET http://YOUR_URL/wp-json/wp-jwt/v1/login?method=facebook&token=FB_ACCESS_TOKEN_OR_CODE
```
