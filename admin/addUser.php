<?php
include('connect.php');
if (isset($_SESSION['user_id'])) {
    header("location:index.php");
}
$message = '';
$first_name = '';
$last_name = '';
$mobile = '';

use PHPMailer\PHPMailer\PHPMailer;

require_once 'phpmailer/Exception.php';
require_once 'phpmailer/PHPMailer.php';
require_once 'phpmailer/SMTP.php';
$mail = new PHPMailer(true);
if (isset($_POST["register"])) {
    $query = "SELECT * FROM register_user WHERE user_email = :user_email";
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            ':user_email'    =>    $_POST['user_email']
        )
    );
    $no_of_row = $statement->rowCount();
    if ($no_of_row > 0) {
        $message = '<label class="text-danger" >Ten email istnieje już w naszej bazie </label>';
    } else {
        $user_password = trim($_POST["user_password"]);
        $user_password = password_hash($user_password, PASSWORD_DEFAULT);
        $user_activation_code = md5(rand());
        $insert_query = "INSERT INTO register_user (user_name,first_name, last_name, mobile, user_email, user_password, user_activation_code, user_email_status) VALUES (:user_name,:first_name, :last_name, :mobile, :user_email, :user_password, :user_activation_code, :user_email_status)";
        $statement = $connect->prepare($insert_query);
        $statement->execute(
            array(
                ':user_name'            =>    $_POST['user_name'],
                ':first_name'           =>    $_POST['first_name'],
                ':last_name'            =>    $_POST['last_name'],
                ':mobile'               =>    $_POST['mobile'],
                ':user_email'           =>    $_POST['user_email'],
                ':user_password'        =>    $user_password,
                ':user_activation_code' =>    $user_activation_code,
                ':user_email_status'    =>    'not verified'
            )
        );
        $result = $statement->fetchAll();
        if (isset($result)) {
            $base_url = "http://localhost/login/admin/";
            $mail_body = "
			<p>Witamy cię" . $_POST['user_name'] . ",</p>
            <p>Zostałeś pomyślnie zarejestrowany w naszym serwisie aby aktywowac swoje konto wejdz w ten link</p>
            <p>" . $base_url . "verification.php?activation_code=" . $user_activation_code . "</p>
            <p>Dziękujemy i zyczymy udanego korzystania z naszego portalu</p>
            <p>Artur Chrominski | Partyk Jurzyk | Patryk Bielecki</p>
			";
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = '587';
            $mail->SMTPAuth = true;
            $mail->Username = 'artur.chrominski21@gmail.com';
            $mail->Password = 'HEXbinARTch2';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->From = 'artur.chrominski21@gmail.com';
            $mail->FromName = 'Mail Weryfikacyjny TEPTA';
            $mail->AddAddress($_POST['user_email'], $_POST['user_name']);
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
                        <input type="text" name="user_name" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Imię</label>
                        <input type="text" name="first_name" class="form-control" required />
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="form-group">
                        <label>Nazwisko</label>
                        <input type="text" name="last_name" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Telefon</label>
                        <input type="number" name="mobile" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Adres Email</label>
                        <input type="email" name="user_email" class="form-control" required />
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Hasło</label>
                        <input type="password" name="user_password" class="form-control" required />
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