<?php
include('admin/connect.php');
if (isset($_SESSION['user_id'])) {
	header("location:index.php");
}
$message = '';
if (isset($_POST["login"])) {
	$query = "SELECT * FROM register_user WHERE user_email = :user_email";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
			'user_email'	=>	$_POST["user_email"]
		)
	);
	$count = $statement->rowCount();
	if ($count > 0) {
		$result = $statement->fetchAll();
		foreach ($result as $row) {
			if ($row['user_email_status'] == 'verified') {
				if (password_verify($_POST["user_password"], $row["user_password"])) {
					$_SESSION['user_id'] = $row['register_user_id'];
					header("location:index.php");
				} else {
					$message = "<label>Złe hasło. Spróbuj ponownie</label>";
				}
			} else {
				$message = "<label>Twój email nie został zweryfikowany. Sprawdź swoją skrzynkę mailową</label>";
			}
		}
	} else {
		$message = "<label>Zły adres email. Spróbuj ponownie</label>";
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Login</h4>
			</div>
			<div class="panel-body">
				<form method="post">
					<?php echo $message; ?>
					<div class="form-group">
						<label>Emial</label>
						<input type="email" name="user_email" class="form-control" required />
					</div>
					<div class="form-group">
						<label>Hasło</label>
						<input type="password" name="user_password" class="form-control" required />
					</div>
					<div class="form-group">
						<input type="submit" name="login" value="Login" class="btn btn-info" />
					</div>
				</form>
				<a href="register.php">Register</a>
			</div>
		</div>
	</div>
</body>

</html>