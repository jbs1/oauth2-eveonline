<?php
require_once('oauth-header.php');


// If we don't have an authorization code then get one
if (!isset($_GET['code'])) {

    // Fetch the authorization URL from the provider; this returns the
    // urlAuthorize option and generates and applies any necessary parameters
    // (e.g. state).
    $authorizationUrl = $provider->getAuthorizationUrl(['scope'=>$scopes]);

    // Get the state generated for you and store it to the session.
    $_SESSION['oauth2state'] = $provider->getState();

    // Redirect the user to the authorization URL.
    header('Location: ' . $authorizationUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    try {

        // Try to get an access token using the authorization code grant.
        $accessToken = $provider->getAccessToken('authorization_code', [
            'code' => $_GET['code']
        ]);

        // Using the access token, we may look up details about the
        // resource owner.
        $resourceOwner = $provider->getResourceOwner($accessToken);

        header("refresh:5;url=index.php");//redirect to main page after login

        echo "Login successful for the character ".$resourceOwner->toArray()["CharacterName"]."(".$resourceOwner->toArray()["CharacterID"].")<br>You will be automatically redirected.....";

        //save accessToken and char info in session.
        $_SESSION['token-object']=serialize($accessToken);
        $_SESSION['charinfo']=$resourceOwner->toArray();

        $config = Swagger\Client\Configuration::getDefaultConfiguration()->setAccessToken(unserialize($_SESSION['token-object'])->getToken());

        //save corp info
        $api_char = new Swagger\Client\Api\CharacterApi();
        $api_corp = new Swagger\Client\Api\CorporationApi();

        try {
            $corp_id=$api_char->getCharactersCharacterId($_SESSION['charinfo']['CharacterID'])['corporation_id'];
            $_SESSION['charinfo']['CorporationID']=$corp_id;

            $_SESSION['charinfo']['CorporationName']=$api_corp->getCorporationsNames($corp_id, $datasource)[0]['corporation_name'];
        } catch (Exception $e) {
            echo 'Exception: ', $e->getMessage(), PHP_EOL;
        }

    } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {

        // Failed to get the access token or user details.
        exit($e->getMessage());

    }

}

?>
