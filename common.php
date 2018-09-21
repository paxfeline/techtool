<?php

require_once 'google-api-php-client-master/src/Google/autoload.php';

$client = new Google_Client();

$client->setAuthConfig('../goosec.json');
$client->setScopes('email');

//print_r( $client );

function getEmailFromToken($token, $c)
{
	$ticket = $c->verifyIdToken($token);
	
	if ($ticket)
		return $ticket['email'];
		
	return false;
}

function get_client_ip()
{
    $ipaddress = 'UNKNOWN';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    return $ipaddress;
}

?>