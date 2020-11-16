<nav class="navbar">
     <a class="navbar-brand" href="#"><b>Tepta Panel Zarządzania</b></a>
     <?php
     session_start();
     if (isset($_SESSION["adminUsername"])) {
          echo '<h3>Login Success, Welcome - ' . $_SESSION["adminUsername"] . '</h3>';
          echo '<br /><br /><a href="logout.php">Logout</a>';
     }
     ?>
</nav>