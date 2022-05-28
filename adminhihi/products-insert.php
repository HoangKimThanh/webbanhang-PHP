<?php 
    require_once './partials/header.php';
    require_once '../functions/product_categories.php';
    require_once '../functions/products.php';
    require_once '../functions/product_imgs.php';
    require_once './partials/sidenav.php';
?>

<?php 
    if (isset($_POST['submit']) && $_POST['submit'] == 'submit') {
        $product_category_id = $_POST['product_category_id'];
        $name = $_POST['name'];
        $detail = $_POST['detail'];
        $description = $_POST['description'];
        $old_price = $_POST['old_price'];
        if (empty($_POST['new_price'])) {
            $new_price = $old_price;
        } else {
            $new_price = $_POST['new_price'];
        }
        $link_shopee = $_POST['link_shopee'];
        $image = $_FILES['image'];
        $images  = $_FILES['images'];
        $folder = '../assets/img/uploads/';
        $image_name = explode('.', $image['name'])[0] . '-' . time();
        $image_path = $folder .  $image_name;
        move_uploaded_file($image['tmp_name'], $image_path);
        $featured =(isset($_POST['featured']) && $_POST['featured'] == 'on') ? 1 : 0;

        $product_id = insert_product($conn, $product_category_id, $name, $detail, $description, $old_price, $new_price, $image_name, $link_shopee, $featured);
        
        insert_product_imgs($conn, $product_id, $images);
    }
?>

<?php 
    $show_product_category = get_all_product_categories($conn);

    $num_rows = mysqli_num_rows($show_product_category);
    if ($num_rows === 0) {
        echo 'Chưa có danh mục sản phẩm. <a href="product_category-insert.php>Thêm danh mục</a>"';
    } else {
?>
    <div class="admin-content-right-category__add">
        <h1>Thêm sản phẩm</h1>
        <form action="" method="post" enctype="multipart/form-data">
            Chọn danh mục sản phẩm
            <select required name="product_category_id">
                <option value="#">Chọn danh mục</option>
    
                <?php foreach($show_product_category as $each) { ?>
                    <option value="<?php echo $each['id'] ?>"><?php echo $each['name'] ?></option>
                <?php } ?>
            </select>
            <br>
            
            Tên sản phẩm
            <input required type="text" name="name" placeholder="Nhập tên sản phẩm">
            <br>

            Chi tiết
            <textarea name="detail" cols="30" id="editor1" rows="10" placeholder="Nhập chi tiết"></textarea>
            <br>
    
            Mô tả
            <textarea name="description" cols="30" rows="10" placeholder="Nhập mô tả"></textarea>
            <br>
            
            Giá sản phẩm
            <input required type="text" name="old_price" placeholder="Giá sản phẩm">
            <br>
    
            Giá khuyến mãi
            <input type="text" name="new_price" placeholder="Giá khuyến mãi">
            <br>
    
            Ảnh đại diện
            <input required type="file" name="image">
            <br>
    
            Ảnh mô tả
            <input type="file" name="images[]" multiple>
            <br>

            Link shopee
            <input type="text" name="link_shopee" id="">
            <br>
    
            <input type="checkbox" name="featured" > Sản phẩm nổi bật
            
            <button type="submit" name="submit" value="submit">Thêm</button> 
        </form>
    </div>
    <script>
        // Replace the <textarea id="editor1"> with a CKEditor 4
        // instance, using default configuration.
        CKEDITOR.replace( 'editor1' );
    </script>
<?php 
    }
    require_once './partials/footer.php';
?>