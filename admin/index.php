<?php
define('admin', true);
session_start();
include '../functions.php';
include 'connect.php';
if (!isset($_SESSION['account_loggedin'])) {
    header('Location: ../index.php?page=login');
    exit;
}
$stmt = $connect->prepare('SELECT * FROM users WHERE userId = ?');
$stmt->execute([ $_SESSION['account_id'] ]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$account || $account['admin'] != 'admin') {
    header('Location: ../index.php');
    exit;
}
$page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'viewOrder';
if (isset($_GET['page']) && $_GET['page'] == 'logout') {
    session_destroy();
    header('Location: ../index.php');
    exit;
}
$error = '';
include $page . '.php';
?>
