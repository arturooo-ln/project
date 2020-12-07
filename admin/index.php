<?php
include '../functions.php';
$page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'orders';
if (isset($_GET['page']) && $_GET['page'] == 'logout') {
    session_destroy();
    header('Location: ../index.php');
    exit;
}
$error = '';
include $page . '.php';
?>
