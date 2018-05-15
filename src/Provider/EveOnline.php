<?php
namespace jbs1\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use League\OAuth2\Client\Token\AccessToken;
use Psr\Http\Message\ResponseInterface;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;

/**
 * OAuth2 Class for the ESI Swagger API for EVE Online
 * EVE Online and ESI are create by CCP Games
 */
class EveOnline extends AbstractProvider
{
	use BearerAuthorizationTrait;

	public $login_domain = 'https://login.eveonline.com';
	const ACCESS_TOKEN_RESOURCE_OWNER_ID = 'CharacterID';

/*	function __construct(argument)
	{
		# code...
	}*/


    /**
     * Returns the base URL for authorizing a client.
     *
     * Eg. https://oauth.service.com/authorize
     *
     * @return string
     */
    public function getBaseAuthorizationUrl(){
    	return $this->login_domain.'/oauth/authorize';

    }

    /**
     * Returns the base URL for requesting an access token.
     *
     * Eg. https://oauth.service.com/token
     *
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params){
    	return $this->login_domain.'/oauth/token';

    }


    /**
     * Returns the URL for requesting the resource owner's details.
     *
     * @param AccessToken $token
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token){
    	return $this->login_domain.'/oauth/verify';
    }


    /**
     * Returns the default scopes used by this provider.
     *
     * This should only be the scopes that are required to request the details
     * of the resource owner, rather than all the available scopes.
     *
     * @return array
     */
    protected function getDefaultScopes(){
    	return [];
    }

    /**
     * Returns the string that should be used to separate scopes when building
     * the URL for requesting an access token.
     *
     * @return string Scope separator
     */
    protected function getScopeSeparator()
    {
        return ' ';
    }


    /**
     * Checks a provider response for errors.
     *
     * @throws IdentityProviderException
     * @param  ResponseInterface $response
     * @param  array|string $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data){
    	if(!empty($data['error'])){
    		throw new IdentityProviderException($data['error_description'],$response->getStatusCode(),$data);
    	}

    }


    /**
     * Generates a resource owner object from a successful resource owner
     * details request.
     *
     * @param  array $response
     * @param  AccessToken $token
     * @return ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token){
    	return new EveOnlineResourceOwner($response,$token);
    }


}

?>