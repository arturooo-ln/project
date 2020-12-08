<?php
require_once('connect.php');
if (isset($_GET['userId'])) {
    $get_id = $_GET['userId'];
    $sql = "DELETE FROM users WHERE userId = '$get_id'";
    $connect->exec($sql);
    header('location:viewUser.php');
}
