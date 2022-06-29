<?php 
    require_once './partials/header.php';
    require_once '../functions/product_categories.php';
    require_once './partials/sidenav.php';

    $result = get_all_product_categories($conn);
    $num_rows = mysqli_num_rows($result);
?>

    <?php
        if($num_rows > 0) {
            $i = 1;
    ?>
            <p><a href="product_categories-insert.php">Thêm danh mục sản phẩm</a></p>
            <h1 style="text-align: center">Danh sách danh mục sản phẩm</h1>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Tùy biến</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($result as $each) {?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $each['name']; ?></td>
                            <td>
                                <a href="product_categories-update.php?id=<?php echo $each['id'] ?>">Sửa</a> | 
                                <a href="product_categories-delete.php?id=<?php echo $each['id'] ?>">Xóa</a>
                            </td>
                        </tr>
                    <?php 
                        $i++;
                    } ?>
                </tbody>
            </table>
    <?php 
        } else {
            echo 'Chưa có danh mục nào. <a href="product_categories-insert.php">Thêm danh mục</a>';
        };
    ?>

<?php 
    require_once './partials/footer.php';
?>