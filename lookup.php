<?php 
    $title = "Tìm kiếm";
    require_once './partials/header.php';
    if (isset($_GET['q'])) {
        $keyword = filter_var($_GET['q'], FILTER_SANITIZE_STRING);
    }

    $products = get_products_by_keyword($conn, $keyword);
    $num_rows = mysqli_num_rows($products);
?>
<div class="content">
    <div class="container">
        <div class="main">
            <div class="grid wide">
                <div class="row">
                    <p style="margin-left: 16px; margin-bottom: 16px; padding-right: 16px;">Kết quả tìm kiếm cho 
                        <span style="font-weight: bold;"><?php echo $keyword ?></span>
                        <span style="font-weight: bold;">(<?php echo $num_rows . ' kết quả' ?>)</span>
                    </p>
                    <div class="col l-12 m-12 c-12">
                        <div class="products">
                            <div class="row">
                                <?php 
                                    if ($num_rows > 0) { 
                                        foreach ($products as $product) {
                                ?>
                                <div class="col l-3 m-4 c-6">
                                    <a href="cua-hang/<?php echo $product['id'] . '-' . make_url($product['name'])?>" class="product">
                                    <div class="box-img">
                                        <img class="product__image" src="./assets/img/uploads/<?php echo $product['image'] ?>" alt="">
                                    </div>
                                        <div class="product__detail">
                                            <h4 class="product__name"><?php echo $product['name'] ?></h4>
                                            <div class="product__price">
                                                <span class="<?php if($product['old_price'] !=  $product['new_price']) echo 'product__price-old' ?>"><?php echo $product['old_price'] ?></span>
                                                <?php if($product['old_price'] != $product['new_price']) {?>
                                                <span class="product__price-current highlight"><?php echo $product['new_price'] ?></span>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php 
                                    }} else {
                                        echo '<img src="./assets/img/no_search_result.png" style="width:50%; display:block; margin: 0 auto;"/>';
                                    }
                                ?>
                            </div>
                        </div>
                    </div>                
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    require_once './partials/footer.php';
?>