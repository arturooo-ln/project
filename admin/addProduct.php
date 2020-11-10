<?php
include 'head.php';
include 'connect.php';
?>

<body>
    <?php
    include 'navbar.php'
    ?>
    <div class="row">
        <?php
        include 'menu.php'
        ?>
        <div class="col-md-9 items">
            <div class="col-md-9">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="last_name" class="form-control" required />
                </div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label>Product Image</label>
                    <img src="../product_images/" alt="" class="img-field" width="120" height="120">
                    <input type="file" name="picture" class="btn btn-fill" id="picture" required>
                </div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label>Telefon</label>
                    <input type="number" name="price" class="form-control" required />
                </div>
            </div>



            <div class="col-md-9">
                <div class="form-group">
                    <label>Product Category</label>
                    <select name="category_id" id="category_id" class="default-browser custom-select select2">
                        <option value=""></option>
                        <?php
                        $cat = mysqli_query($connect, "SELECT * FROM categories");
                        while ($row = mysqli_fetch_assoc($cat)) :
                        ?>
                        <option value="<?php echo $row['cat_id'] ?>" <?php echo isset($meta['product_cat']) && $meta['product_cat'] == $row['cat_id'] ?  'selected' : '' ?>><?php echo $row['cat_title'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label for="">Product Brand</label>
                    <select name="brand_id" id="brand_id" class="default-browser custom-select select2">
                        <option value=""></option>
                        <?php
                        $cat = mysqli_query($connect, "SELECT * FROM brands");
                        while ($row = mysqli_fetch_assoc($cat)) :
                        ?>
                            <option value="<?php echo $row['brand_id'] ?>" <?php echo isset($meta['product_brand']) && $meta['product_brand'] == $row['brand_id'] ?  'selected' : '' ?>><?php echo $row['brand_title'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label>Słowo kluczowe</label>
                    <input type="text" id="tags" name="tags" required class="form-control" value="">
                </div>
            </div>
            <div class="col-md-9">
                <button type="submit" id="btn_save" name="btn_save" required class="btn btn-fill btn-primary">Dodaj produkt</button>
            </div>
        </div>
    </div>
    </div>
</body>