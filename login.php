<?php
$message = '';
$userFirstName = '';
$userLastName = '';
$userPhone = '';
$userSreet = '';
$userCity = '';
$userProvince = '';
$userZip = '';

use PHPMailer\PHPMailer\PHPMailer;

require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';
$mail = new PHPMailer(true);
if (isset($_POST['login'], $_POST['userEmail'], $_POST['userPassword']) && filter_var($_POST['userEmail'], FILTER_VALIDATE_EMAIL)) {
    $stmt = $pdo->prepare('SELECT * FROM users WHERE userEmail = ?');
    $stmt->execute([$_POST['userEmail']]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);




    if ($account['userStatus'] == 'verified') {
        if ($account && password_verify($_POST['userPassword'], $account['userPassword'])) {
            session_regenerate_id();
            $_SESSION['account_loggedin'] = TRUE;
            $_SESSION['account_id'] = $account['userId'];
            $_SESSION['account_admin'] = $account['admin'] == 'admin';
            $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
            if ($products_in_cart) {
                header('Location: index.php?page=checkout');
            } else {
                header('Location: index.php?page=login');
            }
            exit;
        } else {
            $error = 'Incorrect Email/Password!';
        }
    } else {
        $error = "<label class='text-danger'>Twój mail nie jest zweryfikowany. Jeżeli jestes zarejestrowany sprawdz maila.</label>";
    }
}
if (isset($_POST["register"])) {
    $query = "SELECT * FROM users WHERE userEmail = :userEmail";
    $statement = $pdo->prepare($query);
    $statement->execute(
        array(
            ':userEmail'    =>    $_POST['userEmail']
        )
    );
    $no_of_row = $statement->rowCount();
    if ($no_of_row > 0) {
        $message = '<label class="text-danger" >Ten email istnieje już w naszej bazie </label>';
    } else {
        $userPassword = trim($_POST["userPassword"]);
        $userPassword = password_hash($userPassword, PASSWORD_DEFAULT);
        $userActivation = md5(rand());
        $insert_query = "INSERT INTO users (userName,userFirstName, userLastName, userPhone, userSreet, userCity, userZip, userProvince, userEmail, userPassword, userActivation, userStatus, admin) VALUES (:userName,:userFirstName, :userLastName, :userPhone, :userSreet, :userCity, :userZip, :userProvince, :userEmail, :userPassword, :userActivation, :userStatus, :admin)";
        $statement = $pdo->prepare($insert_query);
        $statement->execute(
            array(
                ':userName'             =>    $_POST['userName'],
                ':userFirstName'        =>    $_POST['userFirstName'],
                ':userLastName'         =>    $_POST['userLastName'],
                ':userPhone'            =>    $_POST['userPhone'],
                ':userSreet'            =>    $_POST['userSreet'],
                ':userCity'             =>    $_POST['userCity'],
                ':userZip'              =>    $_POST['userZip'],
                ':userProvince'         =>    $_POST['userProvince'],
                ':userEmail'            =>    $_POST['userEmail'],
                ':userPassword'         =>    $userPassword,
                ':userActivation'       =>    $userActivation,
                ':userStatus'           =>    'not verified',
                ':admin'                =>    'user',
            )
        );
        $result = $statement->fetchAll();
        if (isset($result)) {
            $base_url = "http://localhost/login/admin/";
            $mail_body = "
			<p>Witamy cię" . $_POST['userName'] . ",</p>
            <p>Zostałeś pomyślnie zarejestrowany w naszym serwisie aby aktywowac swoje konto wejdz w ten link</p>
            <p>" . $base_url . "verification.php?activation_code=" . $userActivation . "</p>
            <p>Dziękujemy i zyczymy udanego korzystania z naszego portalu</p>
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
            $mail->FromName = 'Mail Weryfikacyjny TEPTA';
            $mail->AddAddress($_POST['userEmail'], $_POST['userName']);
            $mail->WordWrap = 50;
            $mail->IsHTML(true);
            $mail->Subject = 'Weryfikacyja';
            $mail->Body = $mail_body;
            if ($mail->Send()) {
                $message = '<label class="text-success">Konto zostało dodane. Na skrzynkę mailową został wysłany mail weryfikujący.</label>';
            }
        }
    }
}


?>
<?= template_header('Konto') ?>
<?php require_once('head.php') ?>


<?php if (!isset($_SESSION['account_loggedin'])) : ?>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <legend>
                    <h1>Zaloguj się</h1>
                </legend>
                <?php if ($error) : ?>
                    <p class="error"><?= $error ?></p>
                <?php endif; ?>
                <form action="index.php?page=login" method="post">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control " name="userEmail" id="userEmail" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Hasło</label>
                                <input type="password" class="form-control" name="userPassword" id="userPassword" required>
                            </div>
                        </div>
                    </div>
                    <div class="row center">
                        <input name="login" type="submit" value="Zaloguj się" class="login_btn">
                    </div>
                </form>
            </div>

            <div class="col-6">
                <legend>
                    <h1>Zarejestruj się</h1>
                </legend>
                <form method="post" id="register_form">
                    <?php echo $message; ?>

                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Nazwa użytkownika</label>
                                <input type="text" name="userName" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Imię</label>
                                <input type="text" name="userFirstName" class="form-control" required />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Nazwisko</label>
                                <input type="text" name="userLastName" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Telefon</label>
                                <input type="number" name="userPhone" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Adress</label>
                                <input type="text" name="userSreet" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Miejscowość</label>
                                <input type="text" name="userCity" class="form-control" required />
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Kod pocztowy</label>
                                <input type="text" name="userZip" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Województwo</label>
                                <input type="text" name="userProvince" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Adres Email</label>
                                <input type="email" name="userEmail" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Hasło</label>
                                <input type="password" name="userPassword" class="form-control" required />
                            </div>
                        </div>
                    </div>
                    <div class="row center">
                        <input name="register" type="submit" id="register" value="Zarejestuj się" class="register_btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>