<?php 
    require_once './partials/header.php';
    require_once '../functions/product_categories.php';

    if(isset($_POST['submit']) && $_POST['submit'] == 'submit') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        update_product_category($conn, $id, $name);
    }

    require_once './partials/sidenav.php';
    
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header('Location:product_category-show.php');
        exit;
    } else {
        $id = $_GET['id'];
    }

    $result = get_product_category_by_id($conn, $id);
    $num_rows = mysqli_num_rows($result);
?>
        <?php
            if($num_rows === 1) {
                $each = mysqli_fetch_array($result);
        ?>

                <div class="admin-content-right-category__add">
                    <h1>Sửa danh mục</h1>
                    <form method="post">
                        <input type="hidden" name="id" value="<?php echo $id?>">
                        <input required type="text" name="name" placeholder="Nhập tên danh mục" value="<?php echo $each['name'] ?>">
                        <button type="submit" name="submit" value="submit">Sửa</button>
                    </form>
                </div>
            </div>
        </div>

        <?php
            } else {
                echo 'Không tìm thấy sản phẩm. <a href="product_category-show.php">Quay lại</a>';
            }
        ?>
<?php 
    require_once './partials/footer.php';
?>