<<<<<<< HEAD
<?php
$servername = "localhost"; 
$username = "root";         
$password = "c7fb782c57468694";            
$dbname = "moc_nguyen";     

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
=======
<?php
$servername = "localhost";  
$username = "root";         
$password = "c7fb782c57468694";            
$dbname = "moc_nguyen";   

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
>>>>>>> origin/thanhnguyen
