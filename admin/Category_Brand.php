<?php
include 'head.php';
include 'connect.php';
if(ISSET($_POST['category'])){
    try{
        $categoryName = $_POST['categoryName'];
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO `category` (`categoryName`) VALUES ('$categoryName')";
        $connect->exec($sql);
    }catch(PDOException $e){
        echo $e->getMessage();
    }
    
    $connect = null;
    header('location:Category_Brand.php');
}

if(ISSET($_POST['brand'])){
    try{
        $brandName = $_POST['brandName'];
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO `brand` (`brandName`) VALUES ('$brandName')";
        $connect->exec($sql);
    }catch(PDOException $e){
        echo $e->getMessage();
    }
    $connect = null;
    header('location:Category_Brand.php');
}

?>

<body>
    <?php
    include 'navbar.php'
    ?>
    <div class="row">
        <?php include 'menu.php' ?>
        <!---Category section--->
        <div class="col-md-4 items">
            <label class="headline"><b>Kategoria</b></label>
            <button type="submit" id="btn_save" name="btn_save" data-toggle="modal" data-target="#category" required class="btn btn-fill btn-primary float-right">Dodaj Kategorię</button>
            <div class="modal fade" id="category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="exampleModalLabel"><b>Dodaj nową Kategorie </b></h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Nazwa kategorii</label>
                                    <input type="text" name="categoryName" class="form-control" required />
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button name="btn" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                            <button type="submit" name="category" class="btn btn-primary">Dodaj kategorię</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nazwa kategori</th>
                        <th scope="col">Edytuj</th>
                        <th scope="col">Usuń</th>
                    </tr>
                    <thead class="thead-dark">
                        <?php
                        $result = $connect->prepare("SELECT * FROM category GROUP BY categoryId ASC");
                        $result->execute();
                        for ($i = 0; $row = $result->fetch(); $i++) {
                            $id = $row['categoryId'];
                        ?>
                            <tr>
                                <td>
                                    <h4> <?php echo $row['categoryId']; ?></h4>
                                </td>
                                <td>
                                    <h4> <?php echo $row['categoryName']; ?></h4>
                                </td>
                                <td><a href="editProduct.php<?php echo '?id=' . $id; ?>" class="btn btn-info">Edit</a></td>
                                <td><a href="deleteCategory.php<?php echo '?id=' . $id; ?>" class="btn btn-danger">Delete </a></td>
                            </tr>
                        <?php } ?>
            </table>
        </div>




        <!---Brand section--->
        <div class="col-md-4 items">
            <label class="headline"><b>Marka</b></label>
            <button type="submit" id="btn_save" name="btn_save" data-toggle="modal" data-target="#brand" required class="btn btn-fill btn-primary float-right">Dodaj markę</button>
            <div class="modal fade" id="brand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h2 class="modal-title" id="exampleModalLabel"><b>Dodaj nową markę:</b></h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Nazwa marki</label>
                                    <input type="text" name="brandName" class="form-control" required />
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button name="btn" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                            <button type="submit" name="brand" class="btn btn-primary">Dodaj markę</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nazwa marki</th>
                        <th scope="col">Edytuj</th>
                        <th scope="col">Usuń</th>
                    </tr>
                    <thead class="thead-dark">
                        <?php
                        $result = $connect->prepare("SELECT * FROM brand GROUP BY brandId ASC");
                        $result->execute();
                        for ($i = 0; $row = $result->fetch(); $i++) {
                            $id = $row['brandId'];
                        ?>
                            <tr>
                                <td>
                                    <h4> <?php echo $row['brandId']; ?></h4>
                                </td>
                                <td>
                                    <h4> <?php echo $row['brandName']; ?></h4>
                                </td>
                                <td><a href="editProduct.php<?php echo '?id=' . $id; ?>" class="btn btn-info">Edit</a></td>
                                <td><a href="deleteBrand.php<?php echo '?id=' . $id; ?>" class="btn btn-danger">Delete </a></td>
                            </tr>
                        <?php } ?>
            </table>

        </div>

    </div>


    </div>
</body>