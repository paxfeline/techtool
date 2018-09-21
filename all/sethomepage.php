<?php

require '../common.php';

if ( $_POST['gid'] == 'undefined' ) { echo "Error. Bas login."; die(); }

$uemail = getEmailFromToken( $_POST['gid'], $client );

if ( ! $uemail ) { echo "Error. Bad login 2."; die(); }

//echo $uemail;

$servername = "localhost";
$username = "sfcstec4_db";
$password = "trustno1";
$dbname = "sfcstec4_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error)
{
    echo "Error. Connection failed: " . $conn->connect_error;
    die();
}

$sql = "UPDATE `file_owner` SET `homepage` = '" . $_POST['homepage'] . "' WHERE `email` = '" . $uemail . "'";
$result = $conn->query($sql);

echo $result;

$conn->close();

?>