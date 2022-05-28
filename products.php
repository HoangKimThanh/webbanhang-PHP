<?php
    require_once './database/database.php';
    require_once './functions/product_categories.php';

    
    if (!isset($_GET['product_category_id']) && empty($_GET['product_category_id'])) {
        $product_category_id = 0;
        $title = 'Cửa hàng';
    } else {
        $product_category_id = $_GET['product_category_id'];
        $product_category_name = get_product_category_by_id($conn, $product_category_id);
        if (mysqli_num_rows($product_category_name) !== 1) {
            header('Location: 404.html');
            exit;
        }
        $product_category_name = mysqli_fetch_array($product_category_name)['name'];
        $title = $product_category_name;
    }

    require_once './partials/header.php';
?>
<?php 
    
    $page = 1;
    if (isset($_GET['page']) && !empty($_GET['page'])) {
        $page = $_GET['page'];
    }

    $sort = 'asc';
    if (isset($_GET['sort']) && !empty($_GET['sort'])) {
        $sort = $_GET['sort'];
    }

    $total_product = count_products_by_product_category($conn, $product_category_id);
    $product_per_page = 2;
    $num_page = ceil($total_product / $product_per_page);
    $offset = ($page - 1) * $product_per_page;

?>
        <!---------------------------------------- Content ---------------------------------------->
        <div class="content">
            <!---------------------------------------- Container ---------------------------------------->
            <div class="main">
                <div class="container">
                    <div class="grid wide">
                        <div class="row">
                            <div class="col l-12 m-12 c-0">
                                <div class="navigation">
                                    <ul class="navigation-list">
                                        <li>
                                            <a href="./trang-chu">Trang chủ</a>
                                            <span>&rarr;</span>
                                        </li>
                                        <li>
                                            <a href="cua-hang">Cửa hàng</a>
                                        </li>
                                        <?php 
                                            if ($product_category_id != 0) {
                                        ?>
                                        <span>&rarr;</span>
                                        <li>
                                            <a href="cua-hang?product_category_id=<?php echo $product_category_id ?>"><?php echo $product_category_name; ?></a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col l-3 m-0 c-0">
                                <nav class="category">
                                    <ul>
                                        <li class="category-detail">
                                            <a href="./cua-hang" style="<?php if ($product_category_id == 0) echo 'font-weight: bold'?>" >Tất cả
                                                (<?php 
                                                    $total = count_products_by_product_category($conn);
                                                    echo $total;
                                                ?>)
                                            </a>
                                            <ul>
                                                <?php   
                                                    $result = get_all_product_categories($conn);
                                                    foreach($result as $row) {
                                                ?>
                                                <li>
                                                    <a href="cua-hang?product_category_id=<?php echo $row['id'] ?>" style="<?php if($row['id'] == $product_category_id) echo 'font-weight:bold' ?>">
                                                        <?php echo $row['name'] ?> (<?php
                                                            $total = count_products_by_product_category($conn, $row['id']);
                                                            echo $total;
                                                        ?>)
                                                    </a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <div class="col l-9 m-12 c-12">
                                <div class="filter hide-on-mobile hide-on-tablet">
                                    <div class="filter-header">
                                        <span class="filter__sort">Sắp xếp theo</span>
                                        <!-- <div class="btn btn--white">Nổi bật</div>
                                        <div class="btn btn--white btn--active">Tất cả</div>
                                        <div class="btn btn--white">Bán Chạy</div> -->
                                        <select name="price-sort" id="price-sort" class="btn btn--white">
                                            <option value="asc" class="price-sort-option">Giá: Thấp đến cao</option>
                                            <option value="desc" class="price-sort-option" <?php if($sort === 'desc') echo 'selected' ?>>Giá: Cao đến thấp</option>
                                        </select>
                                    </div>
                                    <div class="filter-footer">
                                        <span class="page">
                                            <?php 
                                                $result = get_products_by_product_category($conn, $product_category_id, $product_per_page, $offset, $sort);
                                                $num_rows = mysqli_num_rows($result);
                                            ?>
                                            <span class="highlight"><?php echo $product_per_page * ($page-1) + $num_rows ?></span> /
                                            <span class="total"><?php echo $total_product ?></span>
                                        </span>
                                        <!-- <a href="#" class="filter-btn-left btn btn--white btn--disable">
                                            <i class="fas fa-angle-left"></i>
                                        </a>
                                        <a href="#" class="filter-btn-right btn btn--white">
                                            <i class="fas fa-angle-right"></i>
                                        </a> -->
                                    </div>
                                </div>
                                <div class="products">
                                    <div class="row">
                                        <?php
                                            foreach ($result as $row) {
                                        ?>
                                        <div class="col l-4 m-4 c-6">
                                            <a href="cua-hang/<?php echo $row['id'] . '-' . make_url($row['name'])?>" class="product">
                                            <div class="box-img">
                                                <img class="product__image" src="./assets/img/uploads/<?php echo $row['image'] ?>" alt="">
                                            </div>
                                                <div class="product__detail">
                                                    <h4 class="product__name"><?php echo $row['name'] ?></h4>
                                                    <div class="product__price">
                                                        <span class="<?php if($row['old_price'] !=  $row['new_price']) echo 'product__price-old' ?>"><?php echo $row['old_price'] ?></span>
                                                        <?php if($row['old_price'] != $row['new_price']) {?>
                                                        <span class="product__price-current highlight"><?php echo $row['new_price'] ?></span>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="pagination">
                                    <ul>
                                        <!-- <li class="btn prev">
                                            <span><i class="fas fa-angle-left"></i></span>
                                        </li> -->
                                        <?php 
                                            for($i = 1; $i <= $num_page; $i++) {
                                        ?>
                                        <li class="btn--white <?php if($page == $i) echo 'btn--active'?>">
                                            <a href="cua-hang<?php
                                                if ($product_category_id != 0) {
                                                    echo '?product_category_id=' . $product_category_id . '&';
                                                } else {
                                                    echo '?';
                                                }
                                                echo 'page=' . $i;
                                                if(isset($_GET['sort']) && !empty($_GET['sort'])) 
                                                    echo '&sort='.$_GET['sort'];
                                            ?>"><?php echo $i ?></a>
                                        </li>
                                        <?php } ?>
                                        <!-- <li class="btn--white next">
                                            <span><i class="fas fa-angle-right"></i></span>
                                        </li> -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script>
        $(document).ready(function() {
            $('#price-sort').change(function() {
                let sort = $(this).val();
                let href = window.location.href;

                if (href.indexOf('sort') == -1) {
                    if (href.indexOf('?') == -1) {
                        location.href =  href + '?sort=' + sort;
                        return;
                    } else {
                        location.href =  href + '&sort=' + sort;
                        return;
                    }    
                }
                location.href = (href.indexOf('asc') != -1) ? href.replace('asc', 'desc') : href.replace('desc', 'asc');
            })

        })
    </script>
<?php
    require_once './partials/footer.php';
?>