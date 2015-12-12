# JSON-Web-Token for WordPress

Authenticate to WordPress-Rest-API using JSON-Web-Tokens.


## What are JSON-Web-Tokens

> JSON Web Tokens are an open, industry standard RFC 7519 method for representing claims securely between two parties.

What this quote is trying to say is that JSON-Web-Tokens are super awesome for authenticating to an api
without dealing with OAuth. The server creates a unique token for a user which is sent with every api-request.


## Installation

* Download the latest version
* Install it via the WordPress backend
* Create a unique secret by opening `http://YOUR_DOMAIN/wp-content/plugins/wp-jwt-authentication/create_secret.php`
* Copy this secret and put `define('JWT_SECRET', 'SECRET_HERE');` in wp-config.php
* That's it!


## Requirements

* WordPress 4.3
* WP-API v2 beta-8

If you are using WordPress 4.4 you don't have to install WP-API, because it's in core already!


## Using the plugin

After installing the plugin, a new enpoint is added to your wp-rest-api: `/wp-json/wp-jwt/v1/login`

In order to get a token for a user, you have to make a POST-request to this endpoint by passing a username and password. If the combination is correct you will receive the token and its expiration timestamp.


## ToDo

* set the secret in the backend
* changing expiration-time in backend
