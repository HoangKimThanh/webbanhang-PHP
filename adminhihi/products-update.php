<?php 
    require_once './partials/header.php';
    require_once '../functions/product_categories.php';
    require_once '../functions/products.php';
    require_once '../functions/product_imgs.php';
?>

<?php 
    if(isset($_POST['submit']) && $_POST['submit'] == 'submit') {
        $id = $_POST['id'];
        $product_category_id = addslashes($_POST['product_category_id']);
        $name = addslashes($_POST['name']);
        if($_FILES['image_new']['size'] > 0) {
            $image = $_FILES['image_new'];

            $folder = '../assets/img/uploads/';
            $image_name = explode('.', $image['name'])[0] . '-' . time();
            $image_path = $folder . $file_name;

            move_uploaded_file($image['tmp_name'], $file_path);
        } else {
            $image_name = $_POST['image_old'];
        }
        $detail = $_POST['detail'];
        $description = $_POST['description'];
        $old_price = $_POST['old_price'];
        $new_price = $_POST['new_price'];
        $link_shopee = $_POST['link_shopee'];
        
        $featured = $_POST['featured'] == 'on' ? 1 : 0;

        update_product($conn, $id, $product_category_id, $name, $detail, $description, $old_price, $new_price, $image_name, $link_shopee, $featured);

        $images = $_FILES['images'];

        update_product_imgs($conn, $id, $images);
    }
?>

<?php
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo 'Không tìm thấy sản phẩm';
    } else {
        $id = $_GET['id'];
    }

    $result = get_product_by_id($conn, $id);
    $num_rows = mysqli_num_rows($result);
    
    require_once './partials/sidenav.php';

    $show_product_category = get_all_product_categories($conn);
?>

        <?php
            if($num_rows === 1) {
                $product = mysqli_fetch_array($result);
        ?>

                <div class="admin-content-right-category__add">
                    <h1>Sửa sản phẩm</h1>
                    
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                        Chọn danh mục sản phẩm
                        <select required name="product_category_id">
                            <option value="#">Chọn danh mục</option>

                            <?php foreach($show_product_category as $product_category) { ?>
                                <option value="<?php echo $product_category['id'] ?>"
                                    <?php if($product_category['id'] === $product['product_category_id']) echo 'selected'; ?>
                                ><?php echo $product_category['name'] ?></option>
                            <?php } ?>
                        </select>
                        <br>
                        
                        Tên sản phẩm
                        <input required type="text" name="name" placeholder="Nhập tên sản phẩm" value="<?php echo $product['name']; ?>">
                        <br>

                        Chi tiết
                        <textarea name="detail" cols="30" id="editor1" rows="10" placeholder="Nhập chi tiết"><?php echo $product['detail']; ?></textarea>
                        <br>

                        Mô tả
                        <textarea name="description" cols="30" rows="10" placeholder="Nhập mô tả"><?php echo $product['description']; ?></textarea>
                        <br>
                        
                        Giá sản phẩm
                        <input required type="text" name="old_price" placeholder="Giá sản phẩm" value="<?php echo $product['old_price']; ?>">
                        <br>

                        Giá khuyến mãi
                        <input type="text" name="new_price" placeholder="Giá khuyến mãi" value="<?php echo $product['new_price']; ?>">
                        <br>
                        <br>

                        Ảnh đại diện
                        <img src="../assets/img/uploads/<?php echo $product['image']; ?>" alt="" height="100px">
                        <input type="hidden" name="image_old" value="<?php echo $product['image']; ?>">
                        <br>
                        <br>

                        Đổi ảnh đại diện
                        <input type="file" name="image_new" >
                        <br>
                        <br>

                        Ảnh mô tả
                        <br>
                        <?php 
                            $product_id = $product['id'];
                            $result = get_product_images_by_product_id($conn, $product_id);
                            foreach($result as $row) {
                        ?>
                            <img src="../assets/img/uploads/<?php echo $row['images']; ?>" alt="" width="100px">
                        <?php 
                            };
                        ?>
                        <br>
                        <br>

                        Đổi ảnh mô tả (chọn lại các ảnh)
                        <input type="file" name="images[]" multiple>

                        <br>
                        <br>

                        Link shopee
                        <input type="text" style="width: 100%" name="link_shopee" value="<?php echo $product['link_shopee']; ?>">
                        <br>

                        <input type="checkbox" name="featured" <?php if($product['featured'] == 1) echo 'checked'?>> Sản phẩm nổi bật

                        <button type="submit" name="submit" value="submit">Cập nhật</button> 
                    </form>
                </div>
            </div>
        </div>

        <?php
            } else {
                echo 'Không tìm thấy sản phẩm. <a href="product_category-show.php">Quay lại</a>';
            }
        ?>

    <script>
        // Replace the <textarea id="editor1"> with a CKEditor 4
        // instance, using default configuration.
        CKEDITOR.replace( 'editor1' );
    </script>
<?php 
    require_once './partials/footer.php';
?>