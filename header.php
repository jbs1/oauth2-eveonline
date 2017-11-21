<?php
if(session_status() == PHP_SESSION_NONE){
	session_start();
}

require_once('SwaggerClient-php/vendor/autoload.php');
require_once('vendor/autoload.php');
require_once('provider.php');
require_once('oauth-func.php');

$datasource = "tranquility"; // string | The server name you would like data from

refresh_token();

?>
