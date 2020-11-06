<?php 
$conn = mysqli_connect("localhost","root","","demo");

if(!$conn){
	die("Connection error: " . mysqli_connect_error());	
}
?>