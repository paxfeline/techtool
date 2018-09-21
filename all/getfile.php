<?php

// POST a Google ID token and a file name

// string file_get_contents ( string $filename )

require '../common.php';

$uemail = getEmailFromToken( $_POST['gid'], $client );

$servername = "localhost";
$username = "sfcstec4_db";
$password = "trustno1";
$dbname = "sfcstec4_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM `file_owner` WHERE `email` LIKE '" . $uemail . "'";
$result = $conn->query($sql);

$row = $result->fetch_assoc();

//print_r( explode( "\n", $row["files"] ) );

$files = explode( "\n", $row["files"] );
$files = array_map('trim', $files);

if ( in_array( $_POST[ 'filename' ], $files ) )
{
	// ok
	
	echo file_get_contents( $_POST[ 'filename' ] );
}
else
{
	echo "error0";
}

$conn->close();

?>