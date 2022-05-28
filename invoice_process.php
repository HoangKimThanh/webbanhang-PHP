<?php 
    $title = "Cảm ơn đã đặt hàng";
    require_once './partials/header.php';
    if ($_GET['invoice_id'] && !empty($_GET['invoice_id'])) {
        $invoice_id = $_GET['invoice_id'];
?>

<div class="content">
    <!---------------------------------------- Cart ---------------------------------------->
    <div class="main">
        <div class="row">
            <div class="col l-12 m-12 c-12">
                <div class="order-success">
                    <div class="icon-success">
                        <i class="fas fa-check"></i>
                    </div>
                    <h1> Đặt hàng thành công</h1>
                    <p class="message-thankyou">Cảm ơn bạn đã quan tâm và mua hàng. Chúng tôi đã gửi mail thông báo đến mail đặt hàng của bạn.</p>
                    <p class="message-check">Bạn có thể theo dõi thông tin đơn hàng bằng mã: <?php echo $invoice_id?></p>
                    <a class="btn-continue" href="cua-hang">Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
    } else {
        header('Location: trang-chu');
    }
    require_once './partials/footer.php';
?>
