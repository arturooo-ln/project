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
    </div>
</div>
<div class="container ">
    <div class="row">
        <?php foreach ($recently_added_products as $product) : ?>
            <div class="card border-0" href="index.php?page=product&id=<?= $product['id'] ?>" class="product">
                <img src="admin/imgs/<?= $product['productImage'] ?>" class="card-img-top" width="100%" height="350px" alt="<?= $product['productName'] ?>">
                <div class="card-body">
                    <p class="card-title name"><?= $product['productName'] ?></p>
                    <p class="price"><?= $product['productPrice'] ?> zł </p>
                    <a href="index.php?page=product&id=<?= $product['id'] ?>" class="btn btn-primary btn-lg btn-block">Dodaj do koszyka </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>