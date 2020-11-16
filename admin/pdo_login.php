<?php
include('connect.php');
try {
     $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     if (isset($_POST["login"])) {
          if (empty($_POST["adminUsername"]) || empty($_POST["adminPassword"])) {
               $message = '<label>W każde pole wstaw odpowiednie dane!!!</label>';
          } else {
               $query = "SELECT * FROM admin WHERE adminUsername = :adminUsername AND adminPassword = :adminPassword";
               $statement = $connect->prepare($query);
               $statement->execute(
                    array(
                         'adminUsername'     =>     $_POST["adminUsername"],
                         'adminPassword'     =>     $_POST["adminPassword"]
                    )
               );
               $count = $statement->rowCount();
               if ($count > 0) {
                    $_SESSION["adminUsername"] = $_POST["adminUsername"];
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
               <input type="text" name="adminUsername" class="form-control" />
               <br />
               <label>
                    <h2>Hasło</h2>
               </label>
               <input type="password" name="adminPassword" class="form-control" />
               <br />
               <input type="submit" name="login" class="btn btn-primary  btn-lg" value="Zaloguj się do panelu" />
          </form>
     </div>
     <br />
</body>

</html>