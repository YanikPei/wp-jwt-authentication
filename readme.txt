=== Plugin Name ===
Contributors: ypeiffer
Tags: restapi, json, web token, facebook, accountkit, account kit, account-kit, authentication, login, register
Requires at least: 4.4.0
Tested up to: 4.5.0
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Authenticate to WordPress using JSON-Web-Tokens via username, facebook or accountkit.

== Description ==

= JSON-Web-Token for WordPress =

Authenticate to WordPress using JSON-Web-Tokens.

* Easy to use authentication methods for WordPress Rest-API and Backend
* Authenticate via username and password
* Authenticate via AccountKit
* Authenticate via Facebook
* Give users the possibility to register/login via email, phone number or facebook

= What are JSON-Web-Tokens =

> JSON Web Tokens are an open, industry standard RFC 7519 method for representing claims securely between two parties.

[More on JWT](https://jwt.io/)

= Requirements =

* WordPress 4.4 or higher

= Authenticate via username and password =

In order to get a token for a user, you have to make a GET-request to this endpoint by passing a username and password. If the combination is correct you will receive the token and its expiration timestamp.

` GET http://YOUR_URL/wp-json/wp-jwt/v1/login?username=USERNAME&password=PASSWORD `

= Authenticate via facebook =

[Wiki: Set up Facebook](https://github.com/YanikPei/wp-jwt-authentication/wiki/Set-up-Facebook)

= Authenticate via AccountKit =

[Wiki: Set up AccountKit](https://github.com/YanikPei/wp-jwt-authentication/wiki/Set-up-AccountKit)

== Installation ==

1. Download the latest version.
2. Upload the entire folder to the /wp-content/plugins/ directory.
3. Activate the plugin
4. Go to `settings -> JWT` and create a secret

== Frequently Asked Questions ==


== Screenshots ==

1. Login buttons
2. general settings
3. AccountKit settings
4. Facebook settings

== Changelog ==

= 1.2.0 =
* Add facebook
* add accountkit
* add login buttons
