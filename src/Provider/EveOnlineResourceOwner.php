<?php
namespace jbs1\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

class EveOnlineResourceOwner implements ResourceOwnerInterface{

	protected $owner;
	protected $token;


	public function __construct($response,$token){
		$this->owner =  $response;
		$this->token = $token;

		$client = new Client(['base_uri' => 'https://esi.evetech.net/latest/']);

		$char = $client->request('GET',"characters/".$this->owner['CharacterID']);
		$this->owner['CorporationID'] = json_decode($char->getBody())->corporation_id;

		$corp = $client->request('GET',"corporations/".$this->owner['CorporationID']);
		$this->owner['CorporationName'] = json_decode($corp->getBody())->name;

	}

	public function getId(){
		return $this->owner['CharacterID'] ?: null;
	}

	public function getCharacterID(){
		return $this->owner['CharacterID'] ?: null;
	}

	public function getCharacterName(){
		return $this->owner['CharacterName'] ?: null;
	}

	public function getCorporationID(){
		return $this->owner['CorporationID'] ?: null;
	}

	public function getCorporationName(){
		return $this->owner['CorporationName'] ?: null;
	}

	public function getScopes(){
		return $this->owner['Scopes'] ?: null;
	}

	public function getTokenType(){
		return $this->owner['TokenType'] ?: null;
	}

	public function getCharacterOwnerHash(){
		return $this->owner['CharacterOwnerHash'] ?: null;
	}

	public function toArray(){
		return $this->owner;
	}



}


?>