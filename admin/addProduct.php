<?php
include 'head.php'
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
                    <label>Nazwa</label>
                    <input type="hidden" name="product_id" class="form-control" value="<?php echo isset($_GET['id']) ? $_GET['id'] : '' ?>">
                    <input type="text" id="product_name" required name="product_name" class="form-control" value="<?php echo isset($meta['product_title']) ? $meta['product_title'] : '' ?>">
                </div>
            </div>
            <div class="col-md-9">
                <div class="">
                    <img src="../product_images/<?php echo isset($meta['product_image']) ? $meta['product_image'] : '' ?>" alt="" class="img-field" width="75" height="100">
                    <label for="">Zdjęcie produktu</label>
                    <input type="file" name="picture" <?php echo !isset($meta['product_image']) ? 'required' : '' ?> class="btn btn-fill" id="picture" onchange="displayImg(this,$(this))">
                </div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label>Opis</label>
                    <textarea rows="4" cols="80" id="details" required name="details" class="form-control"><?php echo isset($meta['product_desc']) ? $meta['product_desc'] : '' ?></textarea>
                </div>
            </div>

            <div class="col-md-9">
                <div class="form-group">
                    <label>Cena</label>
                    <input type="text" id="price" name="price" value="<?php echo isset($meta['product_price']) ? $meta['product_price'] : '' ?>" required class="form-control">
                </div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label>Kategoria</label>
                    <select name="category_id" id="category_id" class="default-browser custom-select select2">
                        <option value=""></option>
                        <?php
                        $cat = mysqli_query($con, "select * from categories");
                        while ($row = mysqli_fetch_assoc($cat)) :
                        ?>
                            <option value="<?php echo $row['cat_id'] ?>" <?php echo isset($meta['product_cat']) && $meta['product_cat'] == $row['cat_id'] ?  'selected' : '' ?>><?php echo $row['cat_title'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-9">
                <div class="form-group">
                    <label for="">Marka</label>
                    <select name="brand_id" id="brand_id" class="default-browser custom-select select2">
                        <option value=""></option>
                        <?php
                        $cat = mysqli_query($con, "select * from brands");
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
                    <input type="text" id="tags" name="tags" required class="form-control" value="<?php echo isset($meta['product_keywords']) ? $meta['product_keywords'] : '' ?>">
                </div>
            </div>
        </div>
    </div>
    </div>
</body>