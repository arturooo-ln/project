<?php
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM product WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        die('Product does not exist!');
    }
} else {
    die('Product does not exist!');
}
?>
<?php template_header('Product') ?>
<?php require_once('head.php') ?>
<div class="container">
    <div class="row">
        <div class="col-7">
            <img class="product_img" src="admin/imgs/<?= $product['productImage'] ?>" alt="<?= $product['productName'] ?>">
        </div>
        <div class="col-5">
            <h1 class="product_name"><?= $product['productName'] ?></h1>
            <p class="brand_category"><?= $product['productCategory'] ?> / <?= $product['productBrand'] ?></p>
            <span class="product_price"><?= $product['productPrice'] ?> zł </span>
            <form action="index.php?page=cart" method="post">
                <input type="number" name="quantity" class="form-control cart_quantity" min="1" max="<?= $product['productQuantity'] ?>" placeholder="Podaj ilość" required>
                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                <p><button class="button btn-lg" type="submit">Dodaj do koszyka</button></p>
            </form>
            <div class="description"><?= $product['productDiscription'] ?></div>
            </.>
        </div>
    </div>