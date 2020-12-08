<?php
require_once('connect.php');
if (isset($_GET['id'])) {
    $get_id = $_GET['id'];
    $sql = "DELETE FROM product WHERE id = '$get_id'";
    $connect->exec($sql);
    header('location:viewProduct.php');
}
