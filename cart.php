<?php
if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $stmt = $pdo->prepare('SELECT * FROM product WHERE id = ?');
    $stmt->execute([$_POST['product_id']]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($product && $quantity > 0) {
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    header('location: index.php?page=cart');
    exit;
}
if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
    unset($_SESSION['cart'][$_GET['remove']]);
}
if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    header('location: index.php?page=cart');
    exit;
}
if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: index.php?page=placeorder');
    exit;
}
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products = array();
$subtotal = 0.00;
if ($products_in_cart) {
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM product WHERE id IN (' . $array_to_question_marks . ')');
    $stmt->execute(array_keys($products_in_cart));
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($products as $product) {
        $subtotal += (float)$product['productPrice'] * (int)$products_in_cart[$product['id']];
    }
}
?>

<?= template_header('Koszyk') ?>
<?php require_once('head.php') ?>
<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <h1 class="my-4"><b>Twój koszyk</b></h1>
        </div>
</div>
        <form action="index.php?page=cart" method="post">
            <div class="table-responsive-md">
                <table class="table table-hover">
                    <thead class="cart_thread">
                        <tr>
                            <td>Produkt</td>
                            <td>Nazwa</td>
                            <td>Cena</td>
                            <td>Ilość</td>
                            <td>Razem</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($products)) : ?>
                            <tr>
                                <td colspan="5" style="text-align:center;"><h1>Nie masz żadnych produktów w koszyku. Przejdź do strony głównej aby dokonać zakupu</h1></td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($products as $product) : ?>
                                <tr>
                                    <td class="img">
                                        <a href="index.php?page=product&id=<?= $product['id'] ?>">
                                            <img src="imgs/<?= $product['productImage'] ?>" class="cart_img" alt="<?= $product['productName'] ?>">
                                        </a>
                                    </td>
                                    <td><a class="cart_name" href="index.php?page=product&id=<?= $product['id'] ?>"><?= $product['productName'] ?></a></td>
                                    <td class="price"><?= $product['productPrice'] ?> zł</td>
                                    <td class="quantity">
                                    <div class="col-xs-6">
                                        <input type="number" class="form-control" name="quantity-<?= $product['id'] ?>" value="<?= $products_in_cart[$product['id']] ?>" min="1" max="<?= $product['productQuantity'] ?>" placeholder="Quantity" required>
                                    </div>
                                    </td>
                                    <td class="price"><?= $product['productPrice'] * $products_in_cart[$product['id']] ?> zł </td>
                                    <td><a class ="cart_remove" href="index.php?page=cart&remove=<?= $product['id'] ?>" class="remove">Usuń</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="total">
                    <span class="final_price"><b>Cena: </b></span>
                    <span class="price"><b><?= $subtotal ?> zł </b></span>
                </div>
                <div class="buttons">
                    <input type="submit" class="cart_btn_update" value="Zaktualizuj" name="update">
                    <input type="submit" class="cart_btn" value="Przejdź dalej" name="placeorder">
                </div>
            </div>
        </form>
    </div>
</div>