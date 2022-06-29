<?php 
    $current_page = basename($_SERVER['PHP_SELF']);
    include '../database/database.php';
    include '../functions/invoices.php';
    include '../functions/reviews.php';
?>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="admin-content-left">
                    <ul>
                        <li>
                            <a href="./index.php"><i class="fas fa-chart-line"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fas fa-thumbtack"></i> Danh mục sản phẩm</a>
                            <ul>
                                <li <?php if($current_page == 'product_categories-insert.php') echo 'class="active"'; ?>><a href="./product_categories-insert.php">Thêm danh mục</a></li>
                                <li <?php if($current_page == 'product_categories-show.php') echo 'class="active"'; ?>><a href="./product_categories-show.php">Danh sách danh mục</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa-solid fa-laptop"></i> Sản phẩm</a>
                            <ul>
                                <li <?php if($current_page == 'products-insert.php') echo 'class="active"'; ?>><a href="./products-insert.php">Thêm sản phẩm</a></li>
                                <li <?php if($current_page == 'products-show.php') echo 'class="active"'; ?>><a href="./products-show.php">Danh sách sản phẩm</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="cart__list.php"><i class="fas fa-shopping-cart"></i> 
                                Đơn hàng
                                <?php
                                    $new_invoices = get_new_invoices($conn);
                                    if ($new_invoices > 0) 
                                        echo '<span style="color:red; font-weight: bold;">(' . $new_invoices . ')</span>';
                                ?>
                            </a>
                            <ul>
                                <li <?php if($current_page == 'invoices-show.php') echo 'class="active"'; ?>>
                                    <a href="./invoices-show.php">
                                        Danh sách đơn hàng
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa-solid fa-user"></i> Khách hàng</a>
                            <ul>
                                <li <?php if($current_page == 'customers-show.php') echo 'class="active"'; ?>><a href="./customers-show.php">Danh sách khách hàng</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="fa-solid fa-message"></i> 
                                Đánh giá
                                <?php
                                    $new_reviews = get_new_reviews($conn);
                                    if ($new_reviews > 0) 
                                        echo '<span style="color:red; font-weight: bold;">(' . $new_reviews . ')</span>';
                                ?>
                            </a>
                            <ul>
                                <li <?php if($current_page == 'reviews-show.php') echo 'class="active"'; ?>>
                                    <a href="./reviews-show.php">
                                        Danh sách đánh giá
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- <li>
                            <a href="#"><i class="fas fa-book-open"></i> Bài viết</a>
                            <ul>
                                <li <?php //if($current_page == 'blog-insert.php') echo 'class="active"'; ?>><a href="./blog-insert.php">Thêm bài viết</a></li>
                                <li <?php //if($current_page == 'blog-show.php') echo 'class="active"'; ?>><a href="./blog-show.php">Danh sách bài viết</a></li>
                            </ul>
                        </li> -->
                    </ul>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <?php echo $_SESSION['admin']['account']; ?>
            </div>
        </nav>
    </div>
    

    <div id="layoutSidenav_content">
            <div class="admin-content-right">