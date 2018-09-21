<?php

require '../common.php';

if ( $_POST['gid'] == 'undefined' ) { echo "Error. Bad login."; die(); }

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

$sql = "SELECT * FROM `file_owner` WHERE `email` LIKE '" . $uemail . "'";
$result = $conn->query($sql);

/*$err = mysqli_error( $conn );
{ echo "Error. DB - " . $err; }*/

$row = $result->fetch_assoc();

//print_r( explode( "\n", $row["files"] ) );

$files = explode( "\n", $row["files"] );
$files = array_map('trim', $files);
	
$filename = stripslashes($_POST['filename']);

if ( in_array( $filename, $files ) || ! file_exists($filename) )
{
	// ok
	$filedata = stripslashes($_POST['filedata']);

	if ( empty( $filename ) )
	{
		echo "Error. File name empty.";
		die();
	}
	
	file_put_contents($filename, $filedata);
	file_put_contents("writelog.txt",
			date('l jS \of F Y h:i:s A') . "\n" . get_client_ip() . "\n" .
			$uemail . "\n" . $filename . "\n-----\n",
		FILE_APPEND );
	echo "OK. File saved!";
	
	echo $result->num_rows;
	
	if ( $result->num_rows == 0 )
	{
		$sql = "INSERT INTO `file_owner` (`id`, `email`, `files`) VALUES (NULL, ";
		$sql .= "'" . $uemail . "', '" . $filename . "' )";
		$result = $conn->query($sql);
		/*echo "\n";
		echo $sql;
		echo "\n";*/
		echo "/";
		echo $conn->error;
		echo "/";
	}
	else if ( $result->num_rows == 1 && ! in_array( $filename, $files ) )
	{
		array_push( $files, $filename );
		$sql = "UPDATE `file_owner` SET `file_owner`.`files` = '" . implode( "\n", $files );
		$sql .= "' WHERE `file_owner`.`email` = '" . $uemail . "'";
		$result = $conn->query($sql);
		/*echo "\n";
		echo $sql;
		echo "\n";*/
		echo "/";
		echo $conn->error;
		echo "/";
	}
}
else
	echo "Error. Cannot overwrite another user's file.";

$conn->close();

echo "out!";

?>