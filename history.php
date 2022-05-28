<?php 
    $title = "Lịch sử mua hàng";
    require_once './partials/header.php';
?>
<?php 
    $customer_id = $_SESSION['customer']['id'];
    $invoices = get_invoices_by_customer_id($conn, $customer_id);
?>
    <div class="content">
        <div class="main">
            <div class="grid wide">
                <div class="history" style="padding-top: 50px;">
                    <?php 
                        if (mysqli_num_rows($invoices) > 0) {
                    ?>
                    <h2 style="text-align: center;">Danh sách hóa đơn đã mua</h2>
                    <ul>
                        <table style="width: 100%; text-align: center" border="1">
                            <thead>
                                <tr>
                                    <th style="padding: 12px 0;">Mã hóa đơn</th>
                                    <th style="padding: 12px 0;">Ngày mua</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($invoices as $invoice) {?>
                                    <tr>
                                        <td style="padding: 12px 0;">
                                            <a style="text-decoration:underline; color:blue;" href="./tra-cuu?invoice_id=<?php echo $invoice['id'] ?>"><?php echo $invoice['id'] ?></a>
                                        </td>
                                        <td style="padding: 12px 0;">
                                            <?php echo $invoice['time'] ?>
                                        </td>
                                    </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </ul>
                    <?php
                        } else {
                            echo '<h2 style="padding-top: 50px;">Bạn chưa có hóa đơn nào :(</h2>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php 
    require_once './partials/footer.php';
?>