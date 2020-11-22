<?php
$stmt = $pdo->prepare('SELECT * FROM product ORDER BY productDate');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?= template_header('Home') ?>
<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <h1 class="my-4"><b>NEW_______</b></h1>
        </div>
        <div class="row">
            <div class="products text-center">
                <?php foreach ($recently_added_products as $product) : ?>
                    <a href="index.php?page=product&id=<?= $product['id'] ?>" class="product">
                        <img src="imgs/<?= $product['productImage'] ?>" width="350" height="350" alt="<?= $product['productName'] ?>">
                        <span class="name"><?= $product['productName'] ?></span>
                        <span class="price"><?= $product['productPrice'] ?> zł </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
