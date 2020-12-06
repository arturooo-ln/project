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

