<?php
include('connect.php');
$message = '';
if (isset($_GET['activation_code'])) {
	$query = "SELECT * FROM users WHERE userActivation = :userActivation";
	$statement = $connect->prepare($query);
	$statement->execute(
		array(
			':userActivation'	=>	$_GET['activation_code']
		)
	);
	$no_of_row = $statement->rowCount();

	if ($no_of_row > 0) {
		$result = $statement->fetchAll();
		foreach ($result as $row) {
			if ($row['userStatus'] == 'not verified') {
				$update_query = "UPDATE users SET userStatus = 'verified' WHERE userId = '" . $row['userId'] . "'";
				$statement = $connect->prepare($update_query);
				$statement->execute();
				$sub_result = $statement->fetchAll();
				if (isset($sub_result)) {
					$message = '<label class="text-success">Twój mail został pomyślnie zweryfikowany możesz przejść Do strony główniej<br/>Przejdź do strony główniej<a href="login.php">Zaloguj się na swoje konto</a></label>';
				}
			} else {
				$message = '<label class="text-info">Twój mail został już zweryfikowany</label>';
			}
		}
	} else {
		$message = '<label class="text-danger">Nie można zweryfikować. Zły link</label>';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Weryfikacja</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<h3><?php echo $message; ?></h3>
	</div>
</body>
</html>