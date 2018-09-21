<html>
<head>
<title></title>
</head>
<body>

<?php

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

$sql = "SELECT * FROM `file_owner`";
$result = $conn->query($sql);

if ( $result->num_rows > 0 )
{
	while ( $row = $result->fetch_assoc() )
	{	
    
		$files = $row['files'];
		$email = $row['email'];

		echo $email;
		echo "<br>";
		if ( strpos( $files, "\n" ) === false )
			echo "<a href=\"" . $files . "\">" . $files . "</a><br>";
		else
		{
			$filear = explode( "\n", $files );
			foreach ( $filear as $file )
				echo "<a href=\"" . $file . "\">" . $file . "</a><br>";
		}
		echo "<br>";
	}
}

$conn->close();

?>

</body>
</html>