<?php
include('connect.php');
if (isset($_SESSION['userId'])) {
    header("location:index.php");
}
$message = '';
$userFirstName = '';
$userLastName = '';
$userPhone = '';

use PHPMailer\PHPMailer\PHPMailer;

require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';
$mail = new PHPMailer(true);
if (isset($_POST["register"])) {
    $query = "SELECT * FROM users WHERE userEmail = :userEmail";
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            ':userEmail'    =>    $_POST['userEmail']
        )
    );
    $no_of_row = $statement->rowCount();
    if ($no_of_row > 0) {
        $message = '<label class="text-danger" >Ten email istnieje już w naszej bazie </label>';
    } 
    else {
        $userPassword = trim($_POST["userPassword"]);
        $userPassword = password_hash($userPassword, PASSWORD_DEFAULT);
        $userActivation = md5(rand());
        $insert_query = "INSERT INTO users (userName,userFirstName, userLastName, userPhone, userEmail, userPassword, userActivation, userStatus) VALUES (:userName,:userFirstName, :userLastName, :userPhone, :userEmail, :userPassword, :userActivation, :userStatus)";
        $statement = $connect->prepare($insert_query);
        $statement->execute(
            array(
                ':userName'             =>    $_POST['userName'],
                ':userFirstName'        =>    $_POST['userFirstName'],
                ':userLastName'         =>    $_POST['userLastName'],
                ':userPhone'            =>    $_POST['userPhone'],
                ':userEmail'            =>    $_POST['userEmail'],
                ':userPassword'         =>    $userPassword,
                ':userActivation'       =>    $userActivation,
                ':userStatus'           =>    'not verified'
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
            $mail->Username = '';//email
            $mail->Password = '';//hasło
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->From = '';//email
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
<?php
include 'head.php';
?>
<body>
    <?php
    include 'navbar.php'
    ?>
    <div class="row">
        <?php
        include 'menu.php'
        ?>
        <div class="col-md-9 items">
            <form method="post" id="register_form">
                <?php echo $message; ?>
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Nazwa użytkownika</label>
                        <input type="text" name="userName" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Imię</label>
                        <input type="text" name="userFirstName" class="form-control" required />
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="form-group">
                        <label>Nazwisko</label>
                        <input type="text" name="userLastName" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Telefon</label>
                        <input type="number" name="userPhone" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Adres Email</label>
                        <input type="email" name="userEmail" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Hasło</label>
                        <input type="password" name="userPassword" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-9">
                    <button type="submit" id="register" name="register" required class="btn btn-fill btn-primary">Zarejestruj nowego użytkownika</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</body>