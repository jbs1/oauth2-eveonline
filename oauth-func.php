<?php

function refresh_token()//refresh access token if expired
{
	global $provider;
	global $config;
	if(isset($_SESSION['accesstoken-obj'])&&unserialize($_SESSION['accesstoken-obj'])->hasExpired()){//get new access token if expired
		$newAccessToken=$provider->getAccessToken('refresh_token', [
			'refresh_token' => unserialize($_SESSION['accesstoken-obj'])->getRefreshToken()
		]);
		$_SESSION['accesstoken-obj']=serialize($newAccessToken);
		$config = Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken(unserialize($_SESSION['accesstoken-obj'])->getToken());
	}
}

function get_access_token(){
	return unserialize($_SESSION['accesstoken-obj'])->getToken();
}

function get_charid(){
	return $_SESSION['charinfo']['CharacterID'];
}

?>