<?php
include 'head.php';
include 'connect.php';
?>
<body>
    <?php include 'navbar.php'; ?>
    <div class="row">
        <?php include 'menu.php' ?>
        <div class="col-md-10 items">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nick</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Uprawnienia</th>
                        <th scope="col">Edytuj</th>
                        <th scope="col">Usuń</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once('connect.php');
                    $result = $connect->prepare("SELECT * FROM users GROUP BY userId ASC");
                    $result->execute();
                    for ($i = 0; $row = $result->fetch(); $i++) {
                        $id = $row['userId'];
                    ?>
                        <tr>
                            <td>
                                <h4> <?php echo $row['userId']; ?></h4>
                            </td>
                            <td>
                                <h4> <?php echo $row['userName']; ?></h4>
                            </td>
                            <td>
                                <h4> <?php echo $row['userEmail']; ?></h4>
                            </td>
                            <td>
                                <h4> <?php echo $row['userStatus']; ?></h4>
                            </td>
                            <td>
                                <h4> <?php echo $row['admin']; ?></h4>
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