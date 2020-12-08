<nav class="navbar">
     <a class="navbar-brand" href="#"><b>Tepta Panel Zarządzania</b></a>
     <?php
     session_start();
     if (isset($_SESSION["account_admin"])) {
          echo '<br /><br /><a href="logout.php">Wyjście</a>';
     }
     ?>
</nav>