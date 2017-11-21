<?php
require_once('header.php');

if(empty($_SESSION['token-object'])){//if not logged in redirect to
	header('Location: oauth.php');
} else {
	refresh_token();

echo '<!DOCTYPE html>
<html>
<head>';

echo'<meta charset="utf-8">';

echo '<title>EVE-SSO</title>
</head>
<body>';

echo '
<p>EVE-SSO</p>
<p><a href="ses-info.php">Click here to check saved session info</a></p>
';


echo '</body>
</html>';

}

?>
