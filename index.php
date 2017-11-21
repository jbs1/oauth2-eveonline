<?php
require_once('header.php');

if(empty($_SESSION['accesstoken-obj'])){//if not logged in redirect to
	header('Location: oauth.php');
} else {
	token_refresh();

echo '<!DOCTYPE html>
<html>
<head>';

echo'<meta charset="utf-8">';

echo '<title>EVE-SSO</title>
</head>
<body>';

echo 'EVE-SSO';


echo '</body>
</html>';

}

?>
