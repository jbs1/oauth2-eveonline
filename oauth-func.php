<?php

function refresh_token()//refresh access token if expired
{
	global $provider;
	global $config;
	if(isset($_SESSION['token-object'])&&unserialize($_SESSION['token-object'])->hasExpired()){//get new access token if expired
		$newAccessToken=$provider->getAccessToken('refresh_token', [
			'refresh_token' => unserialize($_SESSION['token-object'])->getRefreshToken()
		]);
		$_SESSION['token-object']=serialize($newAccessToken);
		$config = Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken(unserialize($_SESSION['token-object'])->getToken());
	}
}

function get_access_token(){
	return unserialize($_SESSION['token-object'])->getToken();
}

function get_charid(){
	return $_SESSION['charinfo']['CharacterID'];
}

?>