<select onchange="respondToFileList( this, arguments[0] )" id="selectEl" <?php

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

if ($result->num_rows > 1)
{
	die("db error (too  many rows)");
}
else if ( $result->num_rows == 1 )
{
    // output data of each row
    $row = $result->fetch_assoc();	
    
    $homepage = $row['homepage'];

	echo " homepage=\"" . $homepage . "\"";

	/* note: trailing > below intentional */
	?>>
<option>[new file]</option>

<?php
	if ( !empty($row["files"]) )
	{
		$files = explode( "\n", $row["files"] );
	
		foreach( $files as $path )
		{
			echo "<option>" . $path . "</option>\n";
		}
	}
}
else
{
	/* note: trailing > below intentional */
	?>>
<option>[new file]</option>

<?php
}

$conn->close();

?>

</select>