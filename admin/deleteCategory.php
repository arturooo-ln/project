<?php
	if(ISSET($_GET['id'])){
		require_once 'connect.php';
		$id = $_GET['id'];
		$sql = $connect->prepare("DELETE from `category` WHERE `categoryId`='$id'");
		$sql->execute();
		header('location:Category_Brand.php');
	}
?>