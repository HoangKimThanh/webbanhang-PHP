<?php 
    require_once './partials/header.php';
    require_once './partials/sidenav.php';
    require_once '../functions/products.php';

    $result = get_all_products($conn);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows === 0) {
        echo 'Chưa có sản phẩm nào. <a href="products-insert.php">Thêm sản phẩm</a>';
    } else {
?>
    <p><a href="products-insert.php">Thêm sản phẩm</a></p>
    <h1 style="text-align: center;">Danh sách sản phẩm</h1>
    <!-- <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Danh mục</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Giá ưu đãi</th>
                <th>Ảnh đại diện</th>
                <th>Tùy biến</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                /*$i = 0;
                foreach ($result as $each) {
                    $i++;
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $each['product_category_name']; ?></td>
                    <td><?php echo $each['name']; ?></td>
                    <td><?php echo $each['old_price']; ?></td>
                    <td><?php if ($each['new_price'] > 0) echo $each['new_price']; ?></td>
                    <td><img src="../assets/img/uploads/<?php echo $each['image'] ?>" alt=""></td>
                    <td>
                        <a href="products-update.php?id=<?php echo $each['id'] ?>">Sửa</a> | 
                        <a href="products-delete.php?id=<?php echo $each['id'] ?>">Xóa</a>
                    </td>
                </tr>
            <?php
                };*/
            ?>
        </tbody>
    </table> -->

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Danh sách sản phẩm
        </div>
        <div class="card-body">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Danh mục</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Giá ưu đãi</th>
                        <th>Ảnh đại diện</th>
                        <th>Tùy biến</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>STT</th>
                        <th>Danh mục</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Giá ưu đãi</th>
                        <th>Ảnh đại diện</th>
                        <th>Tùy biến</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                        $i = 0;
                        echo '<span class="num_rows" style="display:none">' . mysqli_num_rows($result) . '</span>';
                        foreach ($result as $each) {
                            $i++;
                    ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $each['product_category_name']; ?></td>
                            <td><?php echo $each['name']; ?></td>
                            <td><?php echo $each['old_price']; ?></td>
                            <td><?php if ($each['new_price'] > 0) echo $each['new_price']; ?></td>
                            <td><img src="../assets/img/uploads/<?php echo $each['image'] ?>" alt=""></td>
                            <td>
                                <a href="products-update.php?id=<?php echo $each['id'] ?>">Sửa</a> | 
                                <a href="products-delete.php?id=<?php echo $each['id'] ?>">Xóa</a>
                            </td>
                        </tr>
                    <?php
                        };
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="./assets/js/datatables-simple-demo.js"></script>
<?php 
    } 
    require_once './partials/footer.php';
?>

