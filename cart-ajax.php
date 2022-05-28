<?php 
    session_start();
    require_once './database/database.php';
    require_once './functions/product_categories.php';
    require_once './functions/products.php';
    require_once './functions/product_imgs.php';
    require_once './functions/customers.php';
    
?>
<?php 
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        if(isset($_POST['quantity']))
            $quantity = $_POST['quantity'];
        $action = $_POST['action'];

        switch ($action) {
            case 'add':
                add_to_cart($conn, $id, $quantity);
                break;
            
            case 'update':
                update_cart($conn, $id, $quantity);
                break;
        
            case 'delete':
                delete_cart($conn, $id);
                break;
                
            default:
                # code...
                break;
        }
    } else {
        header('Location: trang-chu');
        exit;
    }

    function add_to_cart($conn, $id, $quantity) {
        $product = get_product_by_id($conn, $id);
        $product = mysqli_fetch_assoc($product);

        $isExisting = false;

        if(isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];

            for($i = 0; $i < count($cart); $i++) {
                if ($cart[$i]['id'] === $product['id']) {
                    $cart[$i]['quantity'] += $quantity;

                    $_SESSION['cart'] = $cart;
                    $isExisting = true;
                    break;
                }
            }
            
            if (!$isExisting) {
                $product['quantity'] = $quantity;
                array_push($_SESSION['cart'], $product);
            }
        } else {
            $product['quantity'] = $quantity;
            $_SESSION['cart'][] = $product;
        }
        
        echo '<span>' . count($_SESSION['cart']) . '</span>';
        echo 'OK';
        echo '<p class="cart__list-header">Sản Phẩm Mới Thêm</p>
        <ul class="cart__list-list">';
        foreach ($_SESSION['cart'] as $each) {
            echo  '<li class="cart__list-item">
                    <a href="#" class="cart__list-item-link">
                        <img class="cart__list-item-img" src="./assets/img/uploads/'. $each['image'] .'" alt="">
                        
                        <div class="cart__list-item-description">
                            <div class="cart__list-item-heading">
                                <h4 class="cart__list-item-name">'.$each['name'].'</h4>
                                
                                <div class="cart__list-item-detail">
                                    <span class="cart__list-item-cost highlight">'.$each['new_price'].'</span>
                                    <span class="cart__list-item-multiply">x</span>
                                    <span class="cart__list-item-quanlity">'.$each['quantity'].'</span>
                                    
                                </div>
                            </div>
                        </div>
                    </a>
                </li>';
        }
        echo '</ul>';
        echo '<div class="cart__list-footer">
            <a href="./gio-hang" class="btn">Xem Giỏ Hàng</a>
        </div>';
    }

    function update_cart($conn, $id, $quantity) {
        $cart = $_SESSION['cart'];
        for($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]['id'] == $id) {
                echo 'OK';
                $cart[$i]['quantity'] = $quantity;
                $_SESSION['cart'] = $cart;
                break;
            }
        }
    }

    function delete_cart($conn, $id) {
        $cart = $_SESSION['cart'];
        for($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]['id'] == $id) {
                unset($_SESSION['cart'][$i]);
                break;
            }
        }

        $_SESSION['cart'] = array_values($_SESSION['cart']);
        if (count($_SESSION['cart']) == 0) {
            echo '';
            echo 'OK';
            echo '<img class="no-cart" src="./assets/img/no_cart.png" alt="">
            <p class="cart__list--empty">Chưa Có Sản Phẩm</p>';
        } else {
            echo count($_SESSION['cart']);
            echo 'OK';
            echo '<p class="cart__list-header">Sản Phẩm Mới Thêm</p>
            <ul class="cart__list-list">';
            foreach ($_SESSION['cart'] as $each) {
                echo  '<li class="cart__list-item">
                        <a href="#" class="cart__list-item-link">
                            <img class="cart__list-item-img" src="./assets/img/uploads/'. $each['image'] .'" alt="">
                            
                            <div class="cart__list-item-description">
                                <div class="cart__list-item-heading">
                                    <h4 class="cart__list-item-name">'.$each['name'].'</h4>
                                    
                                    <div class="cart__list-item-detail">
                                        <span class="cart__list-item-cost highlight">'.$each['new_price'].'</span>
                                        <span class="cart__list-item-multiply">x</span>
                                        <span class="cart__list-item-quanlity">'.$each['quantity'].'</span>
                                        
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>';
            }
            echo '</ul>';
            echo '<div class="cart__list-footer">
                <a href="./gio-hang" class="btn">Xem Giỏ Hàng</a>
            </div>';
        }
    }
?>
