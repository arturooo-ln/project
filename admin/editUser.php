<?php
include 'head.php';
include 'connect.php';
$user = [
    'userName' => '',
    'userEmail' => '',
    'userPassword' => '',
    'userFirstName' => '',
    'userLastName' => '',
    'userPhone' => '',
    'userSreet' => '',
    'userCity' => '',
    'userZip' => '',
    'userProvince' => ''

];
if (isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        $stmt = $connect->prepare('UPDATE users SET userName = ?, userEmail = ?, userPassword = ?, userFirstName = ?, userLastName = ?, userPhone = ?, userSreet = ?, userCity = ?, userZip = ?, userProvince = ? WHERE userId = ?');
        $stmt->execute([
            $_POST['userName'],
            $_POST['userEmail'],
            $_POST['userPassword'],
            $_POST['userFirstName'],
            $_POST['userLastName'],
            $_POST['userPhone'],
            $_POST['userSreet'],
            $_POST['userCity'],
            $_POST['userZip'],
            $_POST['userProvince'],
            $_GET['userId']
        ]);
        header('Location: index.php?page=viewUser');
        exit;
    }
    $stmt = $connect->prepare('SELECT * FROM users WHERE userId = ?');
    $stmt->execute([$_GET['id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<body>
    <?php include 'navbar.php'; ?>
    <div class="row">
        <?php include 'menu.php' ?>
        <div class="col-md-7 items">
            <div class="content-block">
                <form action="" method="post" class="form responsive-width-100">

                    <div class="form-group">
                        <label class="control-label" for="userName">userName</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userName" value="<?= $user['userName'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userEmail">userEmail</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userEmail" value="<?= $user['userEmail'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userPassword">userPassword</label>
                        <div class="controls">
                            <input type="password" class="form-control" name="userPassword" value="<?= $user['userPassword'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userFirstName">userFirstName</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userFirstName" value="<?= $user['userFirstName'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userLastName">userLastName</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userLastName" value="<?= $user['userLastName'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userPhone">userPhone</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userPhone" value="<?= $user['userPhone'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userSreet">userSreet</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userSreet" value="<?= $user['userSreet'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userCity">userCity</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userCity" value="<?= $user['userCity'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userZip">userZip</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userZip" value="<?= $user['userZip'] ?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="userProvince">userProvince</label>
                        <div class="controls">
                            <input type="text" class="form-control" name="userProvince" value="<?= $user['userProvince'] ?>" required>
                        </div>
                    </div>
                    <div class="submit-btns">
                        <input type="submit" name="submit" value="Zapisz zmiany" class="btn btn-info">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>