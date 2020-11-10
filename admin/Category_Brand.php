<?php
include 'head.php';
include 'connect.php';
$sql = 'SELECT * FROM categories';
$statement = $connect->prepare($sql);
$statement->execute();
$categories = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<body>
    <?php
    include 'navbar.php'
    ?>
    <div class="row">
        <?php
        include 'menu.php'
        ?>



        <div class="col-md-4 items">
            <label class="headline"><b>Kategoria</b></label>
            <button type="submit" id="btn_save" name="btn_save" required class="btn btn-fill btn-primary float-right">Dodaj Kategorię</button>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tytuł</th>
                        <th scope="col">Edytuj</th>
                        <th scope="col">Usuń</th>
                    </tr>
                    <thead class="thead-dark">
                        <?php foreach ($categories as $person) : ?>
                            <tr>
                                <td><?= $person->cat_id; ?></td>
                                <td><?= $person->cat_title; ?></td>
                                <td><a href="edit.php?id=<?= $person->id ?>" class="btn btn-info">Edytuj</a></td>
                                <td><a onclick="return confirm('Are you sure you want to delete this entry?')" href="delete.php?id=<?= $person->id ?>" class='btn btn-danger'>Usuń</a></td>
                            </tr>
                        <?php endforeach; ?>
            </table>
        </div>



        <div class="col-md-4 items">
            <label class="headline"><b>Marka</b></label>
            <button type="submit" id="btn_save" name="btn_save" required class="btn btn-fill btn-primary float-right">Dodaj Markę</button>
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Tytuł</th>
                        <th scope="col">Edytuj</th>
                        <th scope="col">Usuń</th>
                    </tr>
                    <thead class="thead-dark">
                        <?php foreach ($categories as $person) : ?>
                            <tr>
                                <td><?= $person->cat_id; ?></td>
                                <td><?= $person->cat_title; ?></td>
                                <td><a href="edit.php?id=<?= $person->id ?>" class="btn btn-info">Edytuj</a></td>
                                <td><a onclick="return confirm('Are you sure you want to delete this entry?')" href="delete.php?id=<?= $person->id ?>" class='btn btn-danger'>Usuń</a></td>
                            </tr>
                        <?php endforeach; ?>
            </table>
            
        </div>

    </div>


    </div>
</body>