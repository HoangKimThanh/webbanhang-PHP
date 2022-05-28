<?php
    $title = "Trang chủ";
    require_once './partials/header.php';
?>
        <!---------------------------------------- Content ---------------------------------------->
        <div class="content">
            <!---------------------------------------- Slider ---------------------------------------->
            <div class="main-mobile main-tablet">
                <div class="slider">
                    <div class="slider-imgs">
                        <a href="cua-hang"><img src="./assets/img/slider-1.jpg" alt=""></a>
                        <a href="cua-hang"><img src="./assets/img/slider-2.jpg" alt=""></a>
                        <a href="cua-hang"><img src="./assets/img/slider-3.jpg" alt=""></a>
                        <a href="cua-hang"><img src="./assets/img/slider-4.jpg" alt=""></a>
                    </div>

                    <div class="slider-dots">
                        <div class="slider-dot slider-dot--active"></div>
                        <div class="slider-dot"></div>
                        <div class="slider-dot"></div>
                        <div class="slider-dot"></div>
                    </div>
                </div>
            </div>

            <div class="top-products">
                <h3>Sản phẩm nổi bật</h3>
                <ul class="autoWidth cs-hidden">
                    <?php 
                        $products = get_products_by_featured($conn);
                        foreach ($products as $product) {
                    ?>
                    <li>
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
                    </li>
                    <?php } ?>
                </ul>
                <a href="cua-hang" class="btn">Xem thêm</a>
            </div>

            <div class="top-news">
                <h3>Tin tức nổi bật</h3>
                <ul class="autoWidth cs-hidden">
                    <li>
                        <a href="tin-tuc" class=" box">
                            <div class="box-img">
                                <img class="news__image" src="./assets/img/news-1.jpg" alt="">
                            </div>
                            <div class="news__detail">
                                <h4 class="news__title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</h4>
                                <p class="news__content">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna.</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="tin-tuc" class=" box">
                            <div class="box-img">
                                <img class="news__image" src="./assets/img/news-2.jpg" alt="">
                            </div>
                            <div class="news__detail">
                                <h4 class="news__title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</h4>
                                <p class="news__content">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna.</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="tin-tuc" class=" box">
                            <div class="box-img">
                                <img class="news__image" src="./assets/img/news-3.jpg" alt="">
                            </div>
                            <div class="news__detail">
                                <h4 class="news__title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</h4>
                                <p class="news__content">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna.</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="tin-tuc" class=" box">
                            <div class="box-img">
                                <img class="news__image" src="./assets/img/news-4.jpg" alt="">
                            </div>
                            <div class="news__detail">
                                <h4 class="news__title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</h4>
                                <p class="news__content">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna.</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="tin-tuc" class=" box">
                            <div class="box-img">
                                <img class="news__image" src="./assets/img/news-5.jpg" alt="">
                            </div>
                            <div class="news__detail">
                                <h4 class="news__title">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</h4>
                                <p class="news__content">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Maecenas porttitor congue massa. Fusce posuere, magna sed pulvinar ultricies, purus lectus malesuada libero, sit amet commodo magna eros quis urna.</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <a href="tin-tuc" class="btn">Xem thêm</a>
            </div>
            <script src="./assets/js/script.js"></script>
            <script src="./assets/js/lightslider.js"></script>
        </div>

<?php
    require_once './partials/footer.php';
?>