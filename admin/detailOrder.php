<?php
include 'head.php';
include 'connect.php';
$account = [
    'userEmail' => '',

];
if (isset($_GET['orderId'])) {
    $stmt = $connect->prepare('SELECT * FROM orderdetail WHERE orderId = ?');
    $stmt->execute([$_GET['orderId']]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<body>
    <?php include 'navbar.php'; ?>
    <div class="row">
        <?php include 'menu.php' ?>
</body>
<div class="col-md-9">
<div class="content-block">
    <form action="" method="post" class="form responsive-width-100">
        <label for="userEmail">Email</label>
        <input type="userEmail" name="userEmail" placeholder="userEmail" value="<?= $account['userEmail'] ?>" required>
    </form>
</div>