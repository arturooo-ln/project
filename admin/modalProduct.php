<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Dodaj nowy produkt</button>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="exampleModalLabel"><b>Dodaj nowy produkt</b></h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="addProduct.php" enctype="multipart/form-data">
          <div class="form-group">
            <label>Nazwa produktu</label>
            <input type="text" name="productName" class="form-control" required />
          </div>
          <div class="form-group">
            <label>Kategoria</label>
            <select class="form-control form-control-lg" name="productCategory" required>
              <?php
              require_once ('connect.php');
              $select = $connect->prepare("SELECT * FROM category");
              $select->execute();
              while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                extract($row)
              ?>
                <option><?php echo $row['categoryName']; ?></option>
              <?php
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Marka</label>
            <select class="form-control form-control-lg" name="productBrand" required>
              <?php
              require_once ('connect.php');
              $select = $connect->prepare("SELECT * FROM brand");
              $select->execute();
              while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                extract($row)
              ?>
                <option><?php echo $row['brandName']; ?></option>
              <?php
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>Tytuł</label>
            <input type="text" name="productTitle" class="form-control" required />
          </div>
          <div class="form-group">
            <label>Cena</label>
            <input type="text" name="productPrice" class="form-control" required />
          </div>
          <div class="form-group">
            <label>Opis</label>
            <textarea name="productDiscription" class="form-control" rows="5" id="comment" required></textarea>
          </div>
          <div class="form-group">
            <label>Ilość</label>
            <input type="text" name="productQuantity" class="form-control" required />
          </div>
          <div class="form-group">
            <label>Zdjęcie</label>
            <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1" required>
          </div>
      </div>
      <div class="modal-footer">
        <button name="btn" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
        <button type="submit" name="Submit" class="btn btn-primary">Dodaj produkt</button>
      </div>
      </form>
    </div>
  </div>
</div>