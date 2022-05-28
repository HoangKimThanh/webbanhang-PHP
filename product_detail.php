<?php 
    require_once './database/database.php';
    require_once './functions/products.php';
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        $product_id = $_GET['id'];
    }
    $product = get_product_by_id($conn, $product_id);
    $num_rows = mysqli_num_rows($product);
    if ($num_rows !== 1) {
        header('Location: ./404.html');
    }
    $product = mysqli_fetch_array($product);
    
    $title = $product['name'];
    require_once './partials/header.php';
    
    $product_imgs = get_product_images_by_product_id($conn, $product_id);
    $reviews = get_reviews_by_product_id($conn, $product_id);

?>
<?php 
    if (isset($_POST['name']) && isset($_POST['email']) && $_POST['content']
    && !empty($_POST['email']) && !empty($_POST['name']) && !empty($_POST['content']
    && isset($_SESSION['token']['review']) && isset($_POST['token']))
    ) {
        if ($_SESSION['token']['review'] != $_POST['token']) {
            return;
        }
        $customer_id = isset($_SESSION['customer']['id']) ? $_SESSION['customer']['id'] : 0;
        $name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : $_SESSION['customer']['name'];
        $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_STRING) : $_SESSION['customer']['email'];
        $content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
        $result = insert_review($conn, $product_id, $customer_id, $name, $email, $content);
        
        if ($result) {
            $_SESSION['tmp_element'] = '<li>
            <div class="head_review">
                <div class="user">
                    <p>Nhận xét của bạn đang chờ được kiểm duyệt</p>
                    <h3>@ <span>' . $name . '</span></h3>
                </div>
                <div class="time">
                    ' . date("H:i:s d-m-Y", time()) . '
                </div>
            </div>
            <div class="body_review">
                <p class="review_content">' . $content . '</p>
            </div>
        </li>';
        }
    }
?>
<?php 
    
?>
    <!---------------------------------------- Content ---------------------------------------->
    <div class="content">
        <!---------------------------------------- Intro ---------------------------------------->
        <div class="main">
        <div class="grid wide">
                <div class="row">
                    <div class="col l-6 m-6 c-12">
                        <div class="row">
                            <div class="col l-2 m-2 c-2">
                                <div class="row">
                                    <div class="col l-12 m-12 c-12">
                                        <img class="product-imgs active" src="./assets/img/uploads/<?php echo $product['image']?>" alt="" width="100%">
                                    </div>
                                    <?php 
                                        foreach ($product_imgs as $product_img) {
                                    ?>
                                        <div class="col l-12 m-12 c-12">
                                            <img class="product-imgs" src="./assets/img/uploads/<?php echo $product_img['images']?>" alt="" width="100%">
                                        </div>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="col l-10 m-10 c-10">
                                <img class="product-img-main" src="./assets/img/uploads/<?php echo $product['image']; ?>" alt="" width="100%">
                            </div>
                        </div>
                    </div>

                    <div class="col l-6 m-6 c-12">
                        <div class="product-box">
                            <h1 class="product-box__name"><?php echo $product['name']; ?></h1>
                            <br>
                            <p>
                                Giá: 
                                <span class="<?php if($product['old_price'] !== $product['new_price']) echo 'product__price-old' ?>"><?php echo $product['old_price']; ?></span>
                                <?php 
                                    if ($product['old_price'] !== $product['new_price']) {
                                ?>
                                <span class="product__price-current highlight"><?php echo $product['new_price']; ?></span>
                                <?php } ?>
                            </p>
                            <br>
                            <div class="product-select-quantity">
                                Số lượng: 
                                <button class="sub btn-quantity-change">-</button>
                                    <span class="quantity">1</span>
                                <button class="add btn-quantity-change">+</button>
                            </div>
                            <br>
                            <button class="add-to-cart">Thêm vào giỏ</button>
                            <p>
                                Mua tại gian hàng chúng tôi trên Shopee: 
                                <a href="<?php echo $product['link_shopee'] ?>">
                                    <img src="./assets/img/shopee.png" alt="link shopee" style="height: 30px">
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col l-12 m-12 c-12">
                        <h2>Chi tiết sản phẩm</h2>
                        <p class="product-box__detail"><?php echo $product['detail']; ?></p>
                    </div>

                    <div class="col l-12 m-12 c-12">
                        <h2>Mô tả sản phẩm</h2>
                        <p class="product-box__description"><?php echo $product['description']; ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col l-12 m-12 c-12">
                        <div class="review">
                            <?php if(mysqli_num_rows($reviews) > 0) { ?>
                            <h2>ĐÁNH GIÁ</h2>
                            <ul class="list-reviews">
                                <?php foreach($reviews as $review) {?>
                                <li>
                                    <div class="head_review">
                                        <div class="user">
                                            <h3>@ <span><?=$review['customer_name']?></span></h3>
                                        </div>
                                        <div class="time">
                                            <?=date("H:i:s d-m-Y", strtotime($review['time']))?>
                                        </div>
                                    </div>
                                    <div class="body_review">
                                        <p class="review_content">
                                        <?=$review['content']?>
                                        </p>
                                    </div>
                                </li>
                                <?php 
                                        }; 
                                    }
                                    echo isset($_SESSION['tmp_element']) ?  $_SESSION['tmp_element'] : '';
                                    unset($_SESSION['tmp_element']);
                                ?>
                            </ul>
                            <form method="post" id="form">
                                <input type="hidden" name="token" value="<?php echo $token ?>">
                                <?php 
                                    $_SESSION['token']['review'] = $token;
                                ?>
                                <h2>Đánh giá của bạn</h2>
                                <?php 
                                    if ($isLogged) {
                                ?>
                                    <input type="hidden" name="name" value="<?php echo $_SESSION['customer']['name']?>">
                                    <input type="hidden" name="email" value="<?php echo $_SESSION['customer']['email']?>">
                                <?php
                                    }
                                ?>
                                <div class="row">
                                    <?php if (!isset($_SESSION['customer']['id'])) {?>
                                        <div class="col l-6 m-6 c-12">
                                            <div class="form-group">
                                                <label for="name">
                                                    <p>
                                                        Họ và tên
                                                    </p>
                                                </label>
                                                <input id="name" type="text" name="name" placeholder="Họ và tên">
                                                <span class="form-message"></span>
                                            </div>
                                        </div>
                                        <div class="col l-6 m-6 c-12">
                                            <div class="form-group">
                                                <label for="email">
                                                    <p>
                                                        Email
                                                    </p>
                                                </label>
                                                <input id="email" type="text" name="email" placeholder="Email">
                                                <span class="form-message"></span>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                    <label for="content">
                                        <p>
                                            Nội dung đánh giá
                                        </p>
                                    </label>
                                    <textarea id="content" name="content" cols="30" rows="8" placeholder="Nội dung đánh giá"></textarea>
                                    <span class="form-message"></span>
                                </div>
                                <button type="submit" name="submit" value="review">
                                    Gửi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let quantityChangeBtns = document.querySelectorAll('.btn-quantity-change');
        quantityChangeBtns.forEach(element => {
            element.onclick = function() {
                let quantityElement = document.querySelector('.quantity');
                let quantity = parseInt(quantityElement.innerText);
                if (this.classList.contains('add')) {
                    quantity++;
                    quantityElement.innerText = quantity;
                } else if (this.classList.contains('sub')) {
                    if (quantity > 1) {
                        quantity--;
                    }
                    quantityElement.innerText = quantity;
                }
            }
        });

        let productImgs = document.querySelectorAll('.product-imgs');
        productImgs.forEach(productImg => {
            productImg.onclick = () => {
                if (!productImg.classList.contains('active')) {
                    document.querySelector('.product-imgs.active').classList.remove('active');
                    productImg.classList.add('active');
                    document.querySelector('.product-img-main').src = productImg.src;
                }
            }
        })

        $('.add-to-cart').click(function() {
            $.ajax({
                url: 'cart-ajax.php',
                type: 'post',
                data: {
                    id: <?php echo $product_id; ?>,
                    quantity: $('.quantity').text(),
                    action: 'add'
                },
                dataType: 'text',
                success: function(data) {
                    arr_result = data.split('OK');
                    $('.quantity-div').html(arr_result[0]);
                    $('.cart__list').html(arr_result[1]);
                }
            })
        })
    </script>
    <script src="./assets/js/validator.js"></script>
    <script>
        if (document.getElementById('name')) {
            Validator({
                form: '#form',
                formGroupSelector: '.form-group',
                errorElement: '.form-message',
                rules: [
                    Validator.isRequired('#name', 'Vui lòng nhập đầy đủ họ tên'),
                    Validator.isFullName('#name', 'Vui lòng nhập đúng họ tên'),
                    Validator.isRequired('#email', 'Vui lòng nhập email'),
                    Validator.isEmail('#email', 'Vui lòng nhập đúng email'),
                    Validator.isRequired('#content', "Vui lòng nhập nội dung"),
                    
                ],
            })
        } else {
            Validator({
                form: '#form',
                formGroupSelector: '.form-group',
                errorElement: '.form-message',
                rules: [
                    Validator.isRequired('#content', "Vui lòng nhập nội dung"),
                    
                ],
            })
        }
    </script>

<?php
    require_once './partials/footer.php';
?>