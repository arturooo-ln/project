<?php
session_start();
if (isset($_SESSION['account_loggedin'])) {
    unset($_SESSION['account_loggedin']);
    unset($_SESSION['userId']);
}
header('Location: index.php');
?>
