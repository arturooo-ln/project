<?php
require_once ('connect.php');
$get_id=$_GET['id'];
$sql = "DELETE FROM product WHERE productId = '$get_id'";
$connect->exec($sql);
header('location:viewProduct.php');
?>