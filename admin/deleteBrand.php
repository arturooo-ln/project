<?php
	if(ISSET($_GET['id'])){
		require_once 'connect.php';
		$id = $_GET['id'];
		$sql = $connect->prepare("DELETE FROM `brand` WHERE `brandId`='$id'");
		$sql->execute();
		header('location:Category_Brand.php');
	}
?>