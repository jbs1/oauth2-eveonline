
# EVE-srpmail


## Installation

Add this to your composer.json:
```
"repositories":[
	{
		"type": "git",
		"url": "https://github.com/jbs1/oauth2-eveonline.git"
	}
],
"require": {
    "jbs1/oauth2-eveonline": "*@dev",
},
```

## How to Use
The usage is the same as with the generic provider from the PHPleague's client, just with a `jbs1\OAauth2\Client\Provider\EveOnline` provider.


### Authorization Code Flow

```
$provider = new jbs1\OAauth2\Client\Provider\EveOnline([
    'clientId'                => 'demoapp',    // The client ID assigned to you by the provider
    'clientSecret'            => 'demopass',   // The client password assigned to you by the provider
    'redirectUri'             => 'http://example.com/your-redirect-url/',
]);

// If we don't have an authorization code then get one
if (!isset($_GET['code'])) {

    // Fetch the authorization URL from the provider; this returns the
    // urlAuthorize option and generates and applies any necessary parameters
    // (e.g. state).
    $authorizationUrl = $provider->getAuthorizationUrl();

    // Get the state generated for you and store it to the session.
    $_SESSION['oauth2state'] = $provider->getState();

    // Redirect the user to the authorization URL.
    header('Location: ' . $authorizationUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || (isset($_SESSION['oauth2state']) && $_GET['state'] !== $_SESSION['oauth2state'])) {

    if (isset($_SESSION['oauth2state'])) {
        unset($_SESSION['oauth2state']);
    }
    
    exit('Invalid state');

} else {

    try {

        // Try to get an access token using the authorization code grant.
        $accessToken = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        // We have an access token, which we may use in authenticated
        // requests against the service provider's API.
        echo 'Access Token: ' . $accessToken->getToken() . "<br>";
        echo 'Refresh Token: ' . $accessToken->getRefreshToken() . "<br>";
        echo 'Expired in: ' . $accessToken->getExpires() . "<br>";
        echo 'Already expired? ' . ($accessToken->hasExpired() ? 'expired' : 'not expired') . "<br>";

        // Using the access token, we may look up details about the
        // resource owner.
        $resourceOwner = $provider->getResourceOwner($accessToken);

        var_export($resourceOwner->toArray());

        // The provider provides a way to get an authenticated API request for
        // the service, using the access token; it returns an object conforming
        // to Psr\Http\Message\RequestInterface.
        $request = $provider->getAuthenticatedRequest(
            'GET',
            'http://brentertainment.com/oauth2/lockdin/resource',
            $accessToken
        );

    } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

        // Failed to get the access token or user details.
        exit($e->getMessage());

    }

}

```


### Refresh Token

```
$provider = new \League\OAuth2\Client\Provider\GenericProvider([
    'clientId'                => 'demoapp',    // The client ID assigned to you by the provider
    'clientSecret'            => 'demopass',   // The client password assigned to you by the provider
    'redirectUri'             => 'http://example.com/your-redirect-url/',
]);

$existingAccessToken = getAccessTokenFromYourDataStore();

if ($existingAccessToken->hasExpired()) {
    $newAccessToken = $provider->getAccessToken('refresh_token', [
        'refresh_token' => $existingAccessToken->getRefreshToken()
    ]);

    // Purge old access token and store new access token to your data store.
}
```

### Scopes
Replace the `$provider->getAuthorizationUrl()` with this and the required scopes:

```
$options = [
    'scope' => ['esi-bla.somescope.v1','esi-bla.someotherscope.v1'] // array or string
];
$authorizationUrl = $provider->getAuthorizationUrl($options);
```






#### Credit:
* Base on [oauth2-eve](https://github.com/mostertb/oauth2-eve)
* [Composer](https://getcomposer.org/download/)
* CCP's [ESI API](https://esi.tech.ccp.is/latest/)
* [OAuth Client](https://github.com/thephpleague/oauth2-client)
