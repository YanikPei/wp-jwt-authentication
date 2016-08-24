=== WP Authentication Kit ===
Contributors: ypeiffer
Tags: restapi, json, web token, facebook, accountkit, account kit, account-kit, authentication, login, register
Requires at least: 4.4.0
Tested up to: 4.5.3
Stable tag: 2.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Makes it possible to login to your WordPress backend and Rest API via social networks.

== Description ==

= WordPress Authentication Kit =

Makes it possible to login to your WordPress backend and Rest API via social networks.

* Login via Account Kit (Phone and Email)
* Login via Facebook
* Authenticate to your WP Rest API via JSON Web Tokens, Facebook and AccountKit

== Requirements ==

* WordPress 4.4 or higher

== Installation ==

* Download the latest version.
* Upload the entire folder to the /wp-content/plugins/ directory.
* Activate the plugin
* Go to `Settings -> Authentication Kit` and create a secret

=== Login via facebook ===

[Wiki: Set up Facebook](https://github.com/YanikPei/wp-jwt-authentication/wiki/Set-up-Facebook)

=== Login via AccountKit ===

[Wiki: Set up AccountKit](https://github.com/YanikPei/wp-jwt-authentication/wiki/Set-up-AccountKit)

== WP Rest API ==

=== What are JSON-Web-Tokens ===

> JSON Web Tokens are an open, industry standard RFC 7519 method for representing claims securely between two parties.

[More on JWT](https://jwt.io/)


=== Authenticate via username and password ===

In order to get a token for a user, you have to make a GET-request to this endpoint by passing a username and password. If the combination is correct you will receive the token and its expiration timestamp.

`
GET http://YOUR_URL/wp-json/wp-jwt/v1/login?username=USERNAME&password=PASSWORD
`

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
