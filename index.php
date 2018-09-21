<html>
<head>

<title>SFCS Tech and Coding</title>

<style>

body { background-color: LightCyan; }

.center
{
	width: 60%;
	margin: 0 auto;
	background-color: white;
	padding: 2em;
	text-align: center;
}

</style>

</head>
<body>

<div class="center">

<h1>SFCS Tech and Coding</h1>
<h2>Hand-crafted websites</h2>

<h3>&gt;&gt;<a href="all/makepage.html">Make your own webpage!</a>&lt;&lt;</h3>

<ul>

<?php

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

$sql = "SELECT * FROM `file_owner`";
$result = $conn->query($sql);

while ( $row = $result->fetch_assoc() )
{
	if ( $hp = $row[ 'homepage' ] )
		print( "<li><b>" . explode( "@", $row[ 'email' ] )[0] . "</b>, homepage: <a href=\"all/" . $hp . "\" target=\"_blank\">" . $hp . "</a></li>\n" );
}

?>

</ul>

</div>

</body>
</html>