<?php
include('head.php');
$ID = $_GET['id'];
?>

<body>
    <?php
    include 'navbar.php';
    include 'menu.php'
    ?>
    <div class="col-md-9 items">
        <?php
        include('connect.php');
        $result = $connect->prepare("SELECT * FROM product where productId='$ID'");
        $result->execute();
        for ($i = 0; $row = $result->fetch(); $i++) {
            $id = $row['productId'];
        ?>
            <form class="form-horizontal" method="post" action="edit.php<?php echo '?productId=' . $id; ?>" enctype="multipart/form-data">
                <legend>
                    <h2><b>Edytuj produkt</b></h2>
                    <div class="controls">
                        <button type="submit" name="update" class="btn btn-primary">Zapisz zmiany</button>
                        <a href="viewProduct.php" class="btn btn-warning">Wróć do produktów</a>
                    </div>
                </legend>
                <div class="form-group">
                    <label class="control-label" for="inputPassword">Nazwa produktu</label>
                    <div class="controls">
                        <input type="text" class="form-control" name="productName" required value=<?php echo $row['productName']; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label>Kategoria</label>
                    <input type="text" class="form-control" name="productTitle" required value=<?php echo $row['productCategory']; ?>>
                </div>
                <div class="form-group">
                    <label>Marka</label>
                    <input type="text" class="form-control" name="productTitle" required value=<?php echo $row['productBrand']; ?>>
                </div>
                <div class="form-group">
                    <label class="control-label" for="inputPassword">Tytuł</label>
                    <div class="controls">
                        <input type="text" class="form-control" name="productTitle" required value=<?php echo $row['productTitle']; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="inputPassword">Cena</label>
                    <div class="controls">
                        <input type="number" class="form-control" name="productPrice" required value=<?php echo $row['productPrice']; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="inputPassword">Opis</label>
                    <div class="controls">
                        <textarea type="text" name="productDiscription" class="form-control" rows="5" id="comment" required><?php echo $row['productDiscription']; ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="inputPassword">Zdjęcie produktu</label>
                </div>

                <div class="controls">
                    <input type="file" name="image" class="form-control-file">
                    <img src="uploads/<?php echo $row['productImage']; ?>" alt="Preview" class="img-responsive" />
                </div>
    </div>
    </form>
<?php } ?>
</div>
</body>

</html>