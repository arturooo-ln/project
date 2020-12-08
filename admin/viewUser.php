<?php
include 'head.php';
include 'connect.php';
$stmt = $connect->prepare('SELECT * FROM users');
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                    <?php if (empty($users)) : ?>
                        <tr>
                            <td colspan="8" style="text-align:center;">There are no categories</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($users as $user) : ?>
                            <tr>
                                <td>
                                    <h4><?=$user['userId']?></h4>
                                </td>
                                <td>
                                    <h4><?=$user['userName']?></h4>
                                </td>
                                <td>
                                    <h4><?=$user['userEmail']?></h4>
                                </td>
                                <td>
                                    <h4><?=$user['userStatus']?></h4>
                                </td>
                                <td>
                                    <h4><?=$user['admin']?></h4>
                                </td>
                                <td><a href="editUser.php<?php echo '?id=' . $user['userId']; ?>" class="btn btn-info">Edit</a></td>
                                <td><a href="deleteUser.php<?php echo '?id=' . $user['userId']; ?>" class="btn btn-danger">Delete </a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                </tbody>
            </table>
        </div>
    </div>
</body>