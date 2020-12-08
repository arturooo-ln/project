<?php
include 'connect.php';
$get_id=$_REQUEST['productID'];
$productName= $_POST['productName'];
$productBrand= $_POST['productBrand'];
$productCategory= $_POST['productCategory'];
$productTitle= $_POST['productTitle'];
$productPrice= $_POST['productPrice'];
$sql = "UPDATE product SET productName ='$productName', productBrand ='$productBrand', lname ='$lname', 
address ='$address', email ='$email' WHERE student_id = '$get_id' ";
$connect->exec($sql);
echo "<script>alert('Successfully Edit The Account!'); window.location='viewProduct.php'</script>";


?>

