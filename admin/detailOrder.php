<?php
include 'head.php';
include 'connect.php';
$user = [
    'id_product' => '',
    'img' => '',
    'name' => '',
    'quantity_magazyn' => '',
    'quantity_zamowienie' => '',
    'price' => '',
    'subtotal' => '',
    'userEmail' => '',
    'userFirstName' => '',
    'userLastName' => '',
    'userSreet' => '',
    'userCity' => '',
    'userZip' => '',
    'date_order' => ''

];
if (isset($_GET['id_product'])) {
$stmt = $connect->prepare('SELECT 
x.id AS id_product,
x.productImage AS img,
x.productName AS name, 
x.productQuantity AS quantity_magazyn, 
p.productQuantity AS quantity_zamowienie, 
p.productPrice AS price, 
t.*  
FROM orderdetail = t 
JOIN orderproduct = p ON t.orderId = p.orderId 
JOIN product = x ON x.id = p.productId ');
$stmt->execute();
$stmt->execute([$_GET['id_product']]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<body>
    <?php include 'navbar.php'; ?>
    <div class="row">
        <?php include 'menu.php' ?>
        <div class="col-md-7 items">
            <div class="content-block">
                <form action="" method="post" class="form responsive-width-100">

                    <div class="form-group">
                        <label class="control-label" for="id_product">userName</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="id_product" value="<?= $orders['id_product'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userEmail">userEmail</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userEmail" value="<?= $orders['userEmail'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userEmail">userEmail</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userEmail" value="<?= $orders['userEmail'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userFirstName">userFirstName</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userFirstName" value="<?= $orders['userFirstName'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userLastName">userLastName</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userLastName" value="<?= $orders['userLastName'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userPhone">userPhone</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userPhone" value="<?= $orders['userPhone'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userSreet">userSreet</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userSreet" value="<?= $orders['userSreet'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userCity">userCity</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userCity" value="<?= $orders['userCity'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userZip">userZip</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userZip" value="<?= $orders['userZip'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userProvince">userProvince</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userProvince" value="<?= $orders['userProvince'] ?>" required>
                        </div>
                    </div>
                    <div class="submit-btns">
                        <input type="submit" name="submit" value="Zapisz zmiany" class="btn btn-info">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>