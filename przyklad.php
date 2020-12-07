<?php
if (isset($_GET['id_kategoria'])) {

if (!isset($_POST['ile']) || $_POST['ile']=="Wszystko")
$stmt = $pdo->prepare('SELECT * FROM produkt where id_kategoria=?');
elseif($_POST['ile']==30)
$stmt = $pdo->prepare('SELECT * FROM produkt where id_kategoria=? limit 30');
elseif($_POST['ile']==20)
$stmt = $pdo->prepare('SELECT * FROM produkt where id_kategoria=? limit 20');
elseif($_POST['ile']==10)
$stmt = $pdo->prepare('SELECT * FROM produkt where id_kategoria=? limit 10');
elseif($_POST['ile']==5)
$stmt = $pdo->prepare('SELECT * FROM produkt where id_kategoria=? limit 5');
elseif($_POST['ile']==15)
$stmt = $pdo->prepare('SELECT * FROM produkt where id_kategoria=? limit 15');
elseif($_POST['ile']==25)
$stmt = $pdo->prepare('SELECT * FROM produkt where id_kategoria=? limit 25');

$stmt->execute([$_GET['id_kategoria']]);


    



$kat1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
$kat = $pdo->prepare("SELECT * from kategoria");
$kat->execute();
$ka = $kat->fetchAll(PDO::FETCH_ASSOC);

}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <title>FLEXYstore</title>
        <link rel="icon" href="img/flexstore.png" type="image/icon type">

        <link href="css/styles.css" rel="stylesheet" />
        
        
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">

      <!--Logo-->
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="#">FLEXYstore</a>

            <!--Nav left button-->
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar top-->
                        <ul class="k">
                            <li class="nav-item dropdown">
                                <a href="index.php?page=cart"><i class="fas fa-shopping-cart"></i>
                                <?php
                                if(isset($_SESSION['items'])){
                                    echo '<span>'.$_SESSION['items'].'</span>';
                                }
                                ?>
                                </a>
                            </li>
                        </ul>
            <ul class="u">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user-alt"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <?php
                     if(isset($_SESSION['username'])){
                        echo "<a class='dropdown-item' href='index.php?page=logout'>"."Wyloguj się"."</a>";                  
                     }
                     else{
                        echo "<a class='dropdown-item' href='logowanie.php'>"."Zaloguj się"."</a>";
                     } 
                    ?>   
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Navbar left-->
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">


                            <div class="sb-sidenav-menu-heading">Strony</div>
                            <a class="nav-link nav-active-link" href="index.php?page=home">
                                <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                                Strona Główna
                            </a>
                            <a class="nav-link" href="index.php?page=onas">
                                <div class="sb-nav-link-icon"><i class="fas fa-address-card"></i></div>
                                O nas
                            </a>
                            <a class="nav-link" href="index.php?page=kontakt">
                                <div class="sb-nav-link-icon"><i class="fas fa-comments"></i></div>
                                Kontakt
                            </a>


                            <div class="sb-sidenav-menu-heading">Kategorie</div>
                            <?php foreach($ka as $kate):?>
                            <a class="nav-link" href="index.php?page=kat&id_kategoria=<?=$kate['id_kategoria']?>">
                                <div class="sb-nav-link-icon"></div>
                                <?=$kate['nazwa']?>
                            </a>
                            <?php endforeach; ?>

                            
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                    <?php
                     
                     if(isset($_SESSION['username'])){
                        echo"<div class='small'>"."Zalogowany jako:"."</div>";
                        echo $_SESSION["username"];                       
                     }
                     else{
                        echo "<div class='small'>"."<a href='logowanie.php'>"."Zaloguj się"."</a>"."</div>";
                     } 
                    ?>
                        
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
<main>
<form action="index.php?page=kat&id_kategoria=<?= $_GET['id_kategoria'] ?>" method="POST">
<label>Produktów na stronie:</label>
<select name="ile">
<option value="5">5</option>
<option value="10">10</option>
<option value="15">15</option>
<option value="20">20</option>
<option value="25">25</option>
<option value="30">30</option>
<option value="Wszystko">Wszystko</option>
</select>
<input type="submit" value="Pokaż" class="btn btn-secondary"></input>
</form>

         <div class="offerts">
            <div class="row">
         <?php foreach($kat1 as $product):?>
         <div class="col-xl-3 col-md-6">
         <div class="card bg-card mb-4">
         <a href="index.php?page=product&id_produkt=<?=$product['id_produkt']?>" class="product">
          <img class="card-img" src="img/<?=$product['zdj']?>" alt="<?=$product['nazwa']?>">
          </a>
        <div class="card-footer card-topname d-flex align-items-center justify-content-between">
        <?=$product['nazwa']?>
        <div class="small text-cyan"><?=$product['cena_brutto']?> zł</div>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-between">
        <?php
         $stmt2 = $pdo->prepare('SELECT nazwa from wypisz_kategorie where kategoria = (Select kat from kategoria_produkt where produkt = :kat )');
         $stmt2->bindValue(':kat', $product['id_produkt'] , PDO::PARAM_STR);
         $stmt2->execute();
         while ($kategoria = $stmt2->fetch(PDO::FETCH_ASSOC)){
             $k=$kategoria['nazwa'];
         }
         echo "<h4>".$k."</h4>";
         $sql = $pdo->prepare('SELECT nazwa from wypisz_producent where producent = (Select pro from producent_produkt where produkt = :pro )');   
         $sql->bindValue(':pro', $product['id_produkt'] , PDO::PARAM_STR);
         $sql->execute();
         $pro=$sql->fetch(PDO::FETCH_ASSOC);
         echo "<h3>".$pro['nazwa']."</h3>";
        ?>
        </div>
    
        </div>
           </div>
           <?php endforeach; ?>
              </div>
        </main>
        <footer class="py-4 bg-dark mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Jastrzębska Hepner Gastołek 2020</div>
                            
                        </div>
                    </div>
                </footer>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>

    </body>
</html>