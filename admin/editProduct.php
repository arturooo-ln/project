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
                    <label class="control-label" for="inputPassword">productName:</label>
                    <div class="controls">
                        <input type="text" class="form-control" name="productName" required value=<?php echo $row['productName']; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label>Kategoria</label>

                </div>
                <div class="form-group">
                    <label>Marka</label>
                    <select class="form-control form-control-lg" name="productBrand" required>
                        <?php
                        $select = $connect->prepare("SELECT * FROM brand");
                        $select->execute();
                        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                            extract($row);
                        ?>
                            <option <?php if ($row['brandName'] == $productBrand) { ?> selected="selected" <?php } ?>>
                                <?php echo $row['brandName']; ?></option>

                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label" for="inputPassword">productTitle:</label>
                    <div class="controls">
                        <input type="text" class="form-control" name="productTitle" required value=<?php echo $row['productTitle']; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="inputPassword">productPrice:</label>
                    <div class="controls">
                        <input type="number" class="form-control" name="productPrice" required value=<?php echo $row['productPrice']; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="inputPassword">productDiscription:</label>
                    <div class="controls">
                        <input type="number" class="form-control" name="productDiscription" required value=<?php echo $row['productDiscription']; ?>>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label" for="inputPassword">productImage:</label>
                    <div class="controls">
                        <input type="number" class="form-control" name="productImage" required value=<?php echo $row['productImage']; ?>>
                    </div>
                </div>
            </form>
        <?php } ?>
    </div>
</body>

</html>