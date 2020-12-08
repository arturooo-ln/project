<?php
use PHPMailer\PHPMailer\PHPMailer;

require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';
$mail = new PHPMailer(true);
$account = [
    'userFirstName' => '',
    'userLastName' => '',
    'userPhone' => '',
    'userSreet' => '',
    'userCity' => '',
    'userProvince' => '',
    'userZip' => '',
];
$errors = [];
if (isset($_SESSION['account_loggedin'])) {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE userId = ?');
    $stmt->execute([$_SESSION['account_id']]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);
}
if (isset($_POST['userFirstName'], $_POST['userLastName'], $_POST['userPhone'], $_POST['userSreet'], $_POST['userCity'], $_POST['userProvince'], $_POST['userZip'], $_SESSION['cart'])) {
    $account_id = null;
    if (isset($_SESSION['account_loggedin'])) {
        $stmt = $pdo->prepare('UPDATE users SET userFirstName = ?, userLastName = ?, userPhone = ?, userSreet = ?, userCity = ?, userProvince = ?, userZip = ? WHERE id = ?');
        $stmt->execute([$_POST['userFirstName'], $_POST['userLastName'], $_POST['userPhone'], $_POST['userSreet'], $_POST['userCity'], $_POST['userProvince'], $_POST['userZip'], $_SESSION['account_id']]);
        $account_id = $_SESSION['account_id'];
    } else if (isset($_POST['userEmail'], $_POST['userPassword'], $_POST['cpassword']) && filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare('SELECT userId FROM users WHERE userEmail = ?');
        $stmt->execute([$_POST['userEmail']]);
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $errors[] = 'Konto już istnieje spróbuj ponownie z innym mailem lub skontaktuj się z nami w celu pomocy.';
        }
        if (strlen($_POST['userPassword']) > 25 || strlen($_POST['userPassword']) < 5) {
            $errors[] = 'Hało powinno mieć od 5 do 25 znaków';
        }
        if ($_POST['userPassword'] != $_POST['cpassword']) {
            $errors[] = 'Hasła się nie zgadzają!';
        }
        if (!$errors) {
            $stmt = $pdo->prepare('INSERT INTO users (userEmail, userPassword, userFirstName, userLastName, userSreet, userCity, userProvince, userZip) VALUES (?,?,?,?,?,?,?,?)');
            $userPassword = password_hash($_POST['userPassword'], PASSWORD_DEFAULT);
            $stmt->execute([$_POST['userEmail'], $userPassword, $_POST['userFirstName'], $_POST['userLastName'], $_POST['userPhone'], $_POST['userSreet'], $_POST['userCity'], $_POST['userProvince'], $_POST['userZip']]);
            $account_id = $pdo->lastInsertId();
            $stmt = $pdo->prepare('SELECT * FROM users WHERE userId = ?');
            $stmt->execute([$account_id]);
            $account = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
    if (!$errors) {
        $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
        $products = array();
        $subtotal = 0.00;
        if ($products_in_cart) {
            $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
            $stmt = $pdo->prepare('SELECT * FROM product WHERE id IN (' . $array_to_question_marks . ')');
            $stmt->execute(array_keys($products_in_cart));
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($products as $product) {
                $quantity = (int)$products_in_cart[$product['id']];
                $subtotal += (float)$product['productPrice'] * $quantity;
            }
        }
        if (isset($_POST['checkout']) && $products_in_cart) {
            $stmt = $pdo->prepare('INSERT INTO orderdetail (userId, subtotal, userEmail, userFirstName, userLastName, userPhone, userSreet, userCity, userZip, userProvince, date_order ) VALUES (?,?,?,?,?,?,?,?,?,?,?)');
            $stmt->execute([
                $account_id,
                $subtotal,
                $account ? $account['userEmail'] : $_POST['userEmail'],
                $_POST['userFirstName'],
                $_POST['userLastName'],
                $_POST['userPhone'],
                $_POST['userSreet'],
                $_POST['userCity'],
                $_POST['userZip'],
                $_POST['userProvince'],
                date('Y-m-d H:i:s'),
            ]);
            $order_id = $pdo->lastInsertId();
            $cardName = $_POST['cardName'];
            $cardNumber = password_hash($_POST['cardNumber'], PASSWORD_DEFAULT);
            $cardDate = password_hash($_POST['cardDate'], PASSWORD_DEFAULT);
            $cardCode = password_hash($_POST['cardCode'], PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO orderpayment (orderId, userId, cardName, cardNumber, cardDate, cardCode, status) VALUES (?,?,?,?,?,?,?)');
            $stmt->execute([$order_id, $account_id, $cardName, $cardNumber, $cardDate, $cardCode, 'zatwierdzono']);

            $stmt = $pdo->prepare('INSERT INTO orderproduct (orderId, productId, productPrice, productQuantity, totalPrice) VALUES (?,?,?,?,?)');
            $stmt->execute([$order_id, $product['id'], $product['productPrice'], $quantity,  $subtotal]);

            $stmt = $pdo->prepare('UPDATE product SET productQuantity = productQuantity - ? WHERE productQuantity > 0 AND id = ?');
            $stmt->execute([$quantity, $product['id']]);

            $mail_body = "
			<p>Dziękujemy za zamówienie!</p>
            <p>Przesyłka zostanie wysłana na adres:</p>
            <p><b>Adress: " . $_POST['userSreet'] . "</b></p>
            <p><b>Miejscowość: " . $_POST['userCity'] . "</b></p>
            <p><b>Kod pocztowy: " . $_POST['userZip'] . "</b></p>
            <p><b>Województwo: " . $_POST['userProvince'] . "</b></p>
            <p><h3>Cena za przedmioty: <b>" . $subtotal . "</b></h3></p>
            <p>Dziękujemy i zyczymy udanego korzystania z naszego serwisu</p>
            <p>Artur Chrominski | Partyk Jurzyk | Patryk Bielecki</p>
			";
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '587';
            $mail->SMTPAuth = true;
            $mail->Username = 'tworzeniestron.apk@gmail.com'; //email
            $mail->Password = 'chromjurzybiel'; //hasło
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->From = 'tworzeniestron.apk@gmail.com'; //email
            $mail->FromName = 'Potwierdzenie zamówienia';
            $mail->AddAddress($account['userEmail']);
            $mail->WordWrap = 50;
            $mail->IsHTML(true);
            $mail->Subject = 'Potwierdzenie';
            $mail->Body = $mail_body;
            if ($mail->Send()) {
                $message = '<label class="text-success">Konto zostało dodane. Na skrzynkę mailową został wysłany mail weryfikujący.</label>';
            }





            if ($userId != null) {
                session_regenerate_id();
                $_SESSION['account_loggedin'] = TRUE;
                $_SESSION['account_id'] = $account_id;
                $_SESSION['account_admin'] = $account ? $account['admin'] : 0;
            }
            header('Location: index.php?page=placeorder');
            exit;
        }
    }
    $account = [
        'userFirstName' => $_POST['userFirstName'],
        'userLastName' => $_POST['userLastName'],
        'userPhone' => $_POST['userPhone'],
        'userSreet' => $_POST['userSreet'],
        'userCity' => $_POST['userCity'],
        'userProvince' => $_POST['userProvince'],
        'userZip' => $_POST['userZip'],
    ];
}
if (empty($_SESSION['cart'])) {
    header('Location: index.php?page=cart');
    exit;
}
?>

<?= template_header('Checkout') ?>
<?php require_once('head.php') ?>
<div class="container">
    <h1><b>Potwierdzenie zamówienia</b></h1>
    <?php if (!isset($_SESSION['account_loggedin'])) : ?>
        <h4>
            <p>Jeżeli posiadasz już konto w naszym serwisie <a href="index.php?page=login">Zaloguj się</a></p>
        </h4>
    <?php endif; ?>
    <form action="" method="post">
        <?php if (!isset($_SESSION['account_loggedin'])) : ?>
            <h2><b>Stwórz konto<?php if (!account_required) : ?> (optional)<?php endif; ?></b></h2>
            <div class="row">
                <div class="col-xs-6">
                    <label for="userEmail" class="checkout-form">Email</label>
                    <input type="email" class="form-control " name="userEmail" id="userEmail" placeholder="Twój adres email ">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <label for="userPassword" class="checkout-form">Hasło</label>
                    <input type="password" class="form-control" name="userPassword" id="userPassword" placeholder="Hasło">
                </div>
                <div class="col-xs-4">
                    <label for="cpassword" class="checkout-form">Powtórz hasło</label>
                    <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Powtórz hasło">
                </div>
            </div>
            <h6>* aby zarejestrować się i zamówić produkt uzupełnij poniższe dane </h6>
        <?php endif; ?>
        <h2>Dane do przesyłki</h2>
        <div class="row">
            <div class="col-xs-3">
                <label for="userFirstName" class="checkout-form">Imię</label>
                <input type="text" class="form-control" value="<?= $account['userFirstName'] ?>" name="userFirstName" id="userFirstName" placeholder="Patryk" required>
            </div>
            <div class="col-xs-4">
                <label for="userLastName" class="checkout-form">Nazwisko</label>
                <input type="text" class="form-control" value="<?= $account['userLastName'] ?>" name="userLastName" id="userLastName" placeholder="Bielecki" required>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <label for="userPhone" class="checkout-form">Telefon</label>
                <input type="text" class="form-control" value="<?= $account['userPhone'] ?>" name="userPhone" id="userPhone" placeholder="567 876 567" required>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-5">
                <label for="userSreet" class="checkout-form">Adress </label>
                <input type="text" class="form-control" value="<?= $account['userSreet'] ?>" name="userSreet" id="userSreet" placeholder="Siedlce Piłsudzkiego 60" required>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-5">
                <label for="userCity" class="checkout-form">Miejscowość</label>
                <input type="text" class="form-control" value="<?= $account['userCity'] ?>" name="userCity" id="userCity" placeholder="Siedlce" required>
            </div>
            <div class="col-xs-2">
                <label for="userZip" class="checkout-form">Kod pocztowy</label>
                <input type="text" class="form-control" value="<?= $account['userZip'] ?>" name="userZip" id="userZip" placeholder="08110" required>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-4">
                <label for="userProvince" class="checkout-form">Województwo</label>
                <input type="text" class="form-control" value="<?= $account['userProvince'] ?>" name="userProvince" id="userProvince" placeholder="Mazowieckie" required>
            </div>
        </div>
        <div class="checkout">
            <button type="button" class="checkout_btn" data-toggle="modal" data-target="#myModal">Zapłać za zamówienie</button>
        </div>

        <!--Payment modal--->
        <?php require_once('payment.php') ?>

    </form>
</div>
</div>