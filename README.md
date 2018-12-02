#  Ejabberd wrapper
for ejabberd server connection
##  About
Wrapper tends to simplify connection, access, commands and error logging to ejabberd chat server. 
## Requirements
```
PHP >= 5.4
guzzle/guzzle
```
## Installation
```
composer require devsofpixel7/ejabberd
```
# Configuration
Add to your .env file:
```
EJABBERD_API=http://url-of-your-ejabberd-server:5280/api/
EJABBERD_DOMAIN=http://url-of-your-ejabberd-server
EJABBERD_CONFERENCE_DOMAIN=conference-domain-prefix
EJABBERD_USER=ejabberd-username
EJABBERD_PASSWORD=ejabberd-password
EJABBERD_DEBUG=true
```
# Usage
Basic usage looks like this:
```
$ej = New Ejabberd();
$response = $ej->usersConnectedInfo();
return $response;
```
