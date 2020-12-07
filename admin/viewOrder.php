<?php
include 'head.php';
include 'connect.php';

use PHPMailer\PHPMailer\PHPMailer;

require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';
$mail = new PHPMailer(true);
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
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (isset($_POST['update']) && $order){
    $mail_body = "
    <p>Dziękujemy za zamówienie!</p>
    <p>Przesyłka zostanie wysłana na adres:</p>
    <p>Dziękujemy za zamówienie!</p>
    <p>Przesyłka zostanie wysłana na adres:</p>
    <p><b>Adress: " . $order['userSreet'] . "</b></p>
    <p><b>Miejscowość: " . $order['userCity'] . "</b></p>
    <p><b>Kod pocztowy: " . $order['userZip'] . "</b></p>
    <p><b>Województwo: " . $order['userProvince'] . "</b></p>
    <p><h3>Cena za przedmioty: <b>" . $order['subtotal'] . "</b></h3></p>
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
    $mail->AddAddress($order['userEmail']);
    $mail->WordWrap = 50;
    $mail->IsHTML(true);
    $mail->Subject = 'Potwierdzenie';
    $mail->Body = $mail_body;
    if ($mail->Send()) {
        $message = '<label class="text-success">Konto zostało dodane. Na skrzynkę mailową został wysłany mail weryfikujący.</label>';
    }

}




?>

<body>
    <?php include 'navbar.php'; ?>
    <div class="row">
        <?php include 'menu.php' ?>
</body>
<div class="col-md-9">
    <form method="post">
        
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col"></th>
                    <th scope="col">Nazwa produktu</th>
                    <th scope="col">Ilość na zamówieniu</th>
                    <th scope="col">Email</th>
                    <th scope="col">Cena</th>
                    <th scope="col">Razem</th>
                    <th scope="col">Aktualizacja</th>
                </tr>
            </thead>
            <tbody>

                <?php if (empty($orders)) : ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">Nie ma żadnych zamówień</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($orders as $order) : ?>
                        <tr class="details" onclick="location.href='index.php?page=detailOrder&id=<?= $order['orderId'] ?>'">
                            <td><?= $order['orderId'] ?></td>
                            <td class="img">
                                <?php if (!empty($order['img']) && file_exists('imgs/' . $order['img'])) : ?>
                                    <img src="imgs/<?= $order['img'] ?>" width="100" height="100" alt="<?= $order['name'] ?>">
                                <?php endif; ?>
                            </td>
                            <td><?= $order['name'] ?></td>
                            <td><?= $order['quantity_zamowienie'] ?></td>
                            <td><?= $order['userEmail'] ?></td>
                            <td><?= $order['price'] ?></td>
                            <td><?= $order['subtotal'] ?></td>
                            <td> <input type="submit" class="update" value="Zatwierdź" name="update"></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
</div>