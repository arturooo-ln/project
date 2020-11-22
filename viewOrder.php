<?php
include 'head.php';
include 'connect.php';
?>
<body>
    <?php include 'navbar.php'; ?>
    <div class="row">
        <?php include 'menu.php' ?>
        <div class="col-md-10 items">
            <legend>
                <h2><b>Sekcja Zamówień</b></h2>
            </legend>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nazwa</th>
                        <th scope="col">Kategoria</th>
                        <th scope="col">Marka</th>
                        <th scope="col">Tytuł</th>
                        <th scope="col">Cena</th>
                        <th scope="col">Opis</th>
                        <th scope="col">Zdjęcie</th>
                        <th scope="col">Edytuj</th>
                        <th scope="col">Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $result = $connect->prepare("SELECT * FROM product GROUP BY productId ASC");
                    $result->execute();
                    for ($i = 0; $row = $result->fetch(); $i++) {
                        $id = $row['productId'];
                    ?>
                        <tr>
                            <td>
                                <h4> <?php echo $row['productId']; ?></h4>
                            </td>
                            <td>
                                <h4> <?php echo $row['productName']; ?></h4>
                            </td>
                            <td>
                                <h4> <?php echo $row['productCategory']; ?></h4>
                            </td>
                            <td>
                                <h4> <?php echo $row['productBrand']; ?></h4>
                            </td>
                            <td>
                                <h4> <?php echo $row['productTitle']; ?></h4>
                            </td>
                            <td>
                                <h4> <?php echo $row['productPrice']; ?></h4>
                            </td>
                            <td>
                                <h4> <?php echo $row['productDiscription']; ?></h4>
                            </td>
                            <td>
                                <?php if ($row['productImage'] != "") : ?>
                                    <img src="uploads/<?php echo $row['productImage']; ?>" width="200px" height="200px">
                                <?php endif; ?>
                            </td>
                            <td><a href="editProduct.php<?php echo '?id=' . $id; ?>" class="btn btn-info">Edit</a></td>
                            <td><a href="deleteProduct.php<?php echo '?productId=' . $id; ?>" class="btn btn-danger">Delete </a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>