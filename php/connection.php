 <?php
$servername = "db"; // Server name where the app has the DB
$username = "root"; // user of the DB 
$password = "root"; // password of the DB
$dbname = "test"; // DB name 
// $port = "3306"
// Create connection
// $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?> 
