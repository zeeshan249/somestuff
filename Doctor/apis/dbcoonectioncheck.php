<?php
$servername = "209.58.172.44";
$username = "gbsc_live";
$password = "4#Im4ql8";
$db = "admin_gbsc_live";
// Create connection
$conn = mysqli_connect($servername, $username, $password,$db);
// Check connection
if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM dm_user";
$result = $conn->query($sql);
$row = mysqli_fetch_array($result);
//echo "<pre>";
//print_r($row);
//echo "</pre>";

while ($row = mysqli_fetch_array($result)) {

echo "ID:" .$row{'user_id'}." user_mobile:".$row{'user_mobile'}."<br>";

}

echo "Connected successfully";
?>