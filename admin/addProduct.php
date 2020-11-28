<?php
require_once ('connect.php');
move_uploaded_file($_FILES["image"]["tmp_name"],"imgs/" . $_FILES["image"]["name"]);	
$location=$_FILES["image"]["name"];
$productName= $_POST['productName'];
$productBrand= $_POST['productBrand'];
$productCategory= $_POST['productCategory'];
$productTitle= $_POST['productTitle'];
$productPrice= $_POST['productPrice'];
$productDiscription= $_POST['productDiscription'];
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "INSERT INTO product (productName, productBrand, productCategory, productTitle, productPrice, productDiscription ,productImage)
VALUES ('$productName', '$productBrand', '$productCategory', '$productTitle', '$productPrice', '$productDiscription', '$location')";
$connect->exec($sql);
echo "<script>alert('Produkt został pomyślnie dodany'); window.location='viewProduct.php'</script>";
?>