<nav class="navbar">
<a class="navbar-brand" href="#" ><b>Tepta Panel Zarządzania</b></a>
<?php  
 session_start();  
 if(isset($_SESSION["username"]))  
 {  
      echo '<br /><br /><a href="logout.php">Wyloguj</a>';  
 }  
 else  
 {  
      header("location:pdo_login.php");  
 }  
 ?> 
</nav>


