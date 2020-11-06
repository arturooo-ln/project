<?php
session_start();
$host = "localhost";
$username = "root";
$password = "";
$database = "shop_db";
$message = "";
try {
     $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);
     $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     if (isset($_POST["login"])) {
          if (empty($_POST["username"]) || empty($_POST["password"])) {
               $message = '<label>W każde pole wstaw odpowiednie dane!!!</label>';
          } else {
               $query = "SELECT * FROM users WHERE username = :username AND password = :password";
               $statement = $connect->prepare($query);
               $statement->execute(
                    array(
                         'username'     =>     $_POST["username"],
                         'password'     =>     $_POST["password"]
                    )
               );
               $count = $statement->rowCount();
               if ($count > 0) {
                    $_SESSION["username"] = $_POST["username"];
                    header("location:login_success.php");
               } else {
                    $message = '<label>Podałeś złe dane spróbuj ponownie</label>';
               }
          }
     }
} catch (PDOException $error) {
     $message = $error->getMessage();
}
?>
<!DOCTYPE html>
<html>

<head>
     <title>Tepta Login Panel</title>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
     <link rel="stylesheet" href="loginPanel.css">
</head>

<body>
     <nav class="navbar navbar-dark bg-dark ">
          <a class="navbar-brand" href="#">
               <b>
                    <h1>Tepta Panel Zarządzania</h1>
               </b>
          </a>
     </nav>
     <div class="container" style="width:500px;">
          <?php
          if (isset($message)) {
               echo '<h4><label class="badge badge-danger">' . $message . '</label></h4>';
          }
          ?>
          <form method="post">
               <label>
                    <h2>Nazwa użytkownika</h2>
               </label>
               <input type="text" name="username" class="form-control" />
               <br />
               <label>
                    <h2>Hasło</h2>
               </label>
               <input type="password" name="password" class="form-control" />
               <br />
               <input type="submit" name="login" class="btn btn-primary  btn-lg" value="Zaloguj się do panelu" />
          </form>
     </div>
     <br />
</body>

</html>