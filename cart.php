<?php
    $title = 'Giỏ hàng';
    require_once './partials/header.php';
?>
<?php 

?>
        <!---------------------------------------- Content ---------------------------------------->
        <div class="content">
            <!---------------------------------------- Cart ---------------------------------------->
            <div class="main">
                <div class="cart">
                    <div class="grid wide">
                        <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { 
                            $total = 0;
                        ?>
                        <div class="row cart-table" style="display: <?php if (!isset($_SESSION['cart']))  echo 'none'; else echo 'flex'; ?>">
                            <div class="col l-8 m-12 c-12">
                                <div class="cart-detail">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>SẢN PHẨM</th>
                                                <th>TÊN SẢN PHẨM</th>
                                                <th>SL</th>
                                                <th>THÀNH TIỀN</th>
                                                <th>XÓA</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($_SESSION['cart'] as $product) {
                                                $total += $product['quantity'] * $product['new_price'];
                                            ?>
                                            <tr class="product-id_<?php echo $product['id'] ?>">
                                                <td>
                                                    <a href="cua-hang/<?php echo $product['id'] . '-' . make_url($product['name'])?>">
                                                        <img src="./assets/img/uploads/<?php echo $product['image'] ?>" width="100">
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="cua-hang/<?php echo $product['id'] . '-' . make_url($product['name'])?>"><?php echo $product['name']?></a>
                                                </td>
                                                <td>
                                                    <button data-id="<?php echo $product['id'] ?>" class="sub btn-quantity-change">-</button>
                                                        <span class="quantity_<?php echo $product['id']?>"><?php echo $product['quantity'] ?></span>
                                                    <button data-id="<?php echo $product['id'] ?>" class="add btn-quantity-change">+</button>
                                                </td>
                                                <td>
                                                    <span 
                                                        data-price="<?php echo $product['new_price']?>"
                                                        class="price_<?php echo $product['id']?>"
                                                    ><?php echo $product['new_price'] * $product['quantity'] ?></span>
                                                </td>
                                                <td>
                                                    <button 
                                                        data-id="<?php echo $product['id'] ?>" 
                                                        class="btn-delete" title="Xóa" 
                                                        style="cursor: pointer; padding: 4px; background-color: white; border: 1px solid #000"
                                                    >X</button>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col l-4 m-12 c-12">
                                <div class="cart-money">
                                    <table>
                                        <caption>TỔNG TIỀN GIỎ HÀNG</caption>
                                        <tbody>
                                            <tr>
                                                <td>TỔNG SẢN PHẨM</td>
                                                <td>
                                                    <span class="product-total">
                                                        <?php echo count($_SESSION['cart']) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>TỔNG TIỀN HÀNG</td>
                                                <td>
                                                    <span class="total_1"><?php echo $total ?></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td>TẠM TÍNH</td>
                                                <td>
                                                    <span class="total_2"><?php echo $total ?></span>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="button">
                                        <a href="cua-hang" class="btn btn--ccc">Tiếp tục mua sắm</a>
                                        <a href="dat-hang" class="btn">Đặt hàng</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cart-empty"  style="display: <?php if (!isset($_SESSION['cart']))  echo 'block'; else echo 'none' ?>">
                            <a href="cua-hang" style="display: block; text-align: center">
                                <img style="display: block; width: 50%; margin: 0 auto;" src="./assets/img/empty-cart.jpg"/>
                            </a>
                        </div>
                    <?php } else {
                        echo '<a href="cua-hang" style="display: block; text-align: center" >
                            <img style="display: block; width: 50%; margin: 0 auto;" src="./assets/img/empty-cart.jpg"/>
                        </a>';
                    } ?>
                    </div>
                </div>
            </div>
        </div>

<script>
    let quantityChangeBtns = document.querySelectorAll('.btn-quantity-change');
    let deleteBtns = document.querySelectorAll('.btn-delete');
    quantityChangeBtns.forEach(element => {
        element.onclick = function() {
            id = $(this).data('id');
            let quantityElement = document.querySelector('.quantity_' + id);
            let quantity = parseInt(quantityElement.innerText);
            
            let productPriceElement = document.querySelector('.price_' + id);
            let productPrice = parseInt(productPriceElement.getAttribute('data-price'));
            
            let total = ($('.total_1').text());

            if (this.classList.contains('add')) {
                quantity++;
                total = parseInt(total) + productPrice;
            } else if (this.classList.contains('sub')) {
                if (quantity > 1) {
                    quantity--;
                    total = parseInt(total) - productPrice;
                }
            }

            quantityElement.innerText = quantity;

            document.querySelector(`li[data-id="${id}"] .cart__list-item-quanlity`).innerText = quantity;

            productPriceElement.innerText = productPrice * quantity;

            document.querySelectorAll("[class^=total]").forEach(function(element) {
                element.innerText = total;
            })

            $.ajax({
                url: 'cart-ajax.php',
                type: 'POST',
                data: {
                    id: id,
                    quantity: quantity,
                    action: 'update'
                },
                dataType: 'text',
                success: function(data) {
                    // $('#app').html(data);
                }
            })
        }
    });

    deleteBtns.forEach(function(btn) {
        btn.onclick = function() {
            let id = this.getAttribute('data-id');

            let price = parseInt(document.querySelector('.price_' + id).innerText);

            let total = parseInt(document.querySelector('.total_1').innerText);

            total = total - price;

            document.querySelector('.product-id_' + id).remove();

            document.querySelectorAll("[class^=total]").forEach(function(element) {
                element.innerText = total;
            })

            let allItem = document.querySelectorAll("[class^=product-id]");
            if (allItem.length == 0) {
                document.querySelector('.cart-empty').style.display = 'block';
                document.querySelector('.cart-table').style.display = 'none';
            } else if (allItem.length > 0) {
                document.querySelector('.product-total').innerText = allItem.length;
            }

            $.ajax({
                url: 'cart-ajax.php',
                type: 'POST',
                data: {
                    id: id,
                    action: 'delete'
                },
                dataType: 'text',
                success: function(data) {
                    arr_result = data.split('OK');
                    if(arr_result[0] == '') {
                        $('.quantity-div').remove();
                    } else {
                        $('.quantity-div span').html(arr_result[0]);
                    }
                    $('.cart__list').html(arr_result[1]);
                }
            })
        }
    })
</script>

<?php
    require_once './partials/footer.php';
?>