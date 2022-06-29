<?php 
    require_once './partials/header.php';
    require_once '../functions/product_categories.php';

    if(isset($_POST['submit']) && $_POST['submit'] == 'submit') {
        if(!empty($_POST['name'])) {
            $name = $_POST['name'];
            insert_product_category($conn, $name);
        } else {
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }

    require_once './partials/sidenav.php';
?>
                <div class="admin-content-right-category__add">
                    <h1>Thêm danh mục</h1>
                    <form method="post">
                        <input required type="text" name="name" placeholder="Nhập tên danh mục">
                        <button type="submit" name="submit" value="submit">Thêm</button>
                    </form>
                </div>
<?php 
    require_once './partials/footer.php';
?>