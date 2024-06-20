<?php
session_start();
$uname=$_POST['uname'];
$psw=$_POST['psw'];
$encr_psw=md5($psw);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carss";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql ="SELECT * FROM login WHERE NAME = '$uname' AND PASSWORD = '$encr_psw'";
$result=$conn->query($sql);
if ($result->num_rows > 0) {
    $_SESSION['name']=$uname;
    header('Location:main.php');
}
else{
   
    header('Location:loginerror.html');
}


?>