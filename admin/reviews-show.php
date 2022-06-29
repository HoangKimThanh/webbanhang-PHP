<?php 
    require_once './partials/header.php';
    require_once './partials/sidenav.php';
    require_once '../functions/reviews.php';
    
    $reviews_not_approved = get_reviews_not_approved($conn);
    $reviews_approved = get_reviews_approved($conn);

    if (mysqli_num_rows($reviews_not_approved) == 0 && mysqli_num_rows($reviews_approved) == 0) {
        echo 'Chưa có khách có đánh giá nào';
    } else {
?>
    <h1 style="text-align: center;">Danh sách đánh giá</h1>
    <h2>Đánh giá chưa duyệt</h2>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Sản phẩm</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Nội dung</th>
                <th>Thời gian</th>
                <th>Tùy biến</th>
            </tr>
        </thead>
        <tbody style="font-size: 14px" id="reviews-not-approved">
            <?php 
                $i = 0;
                foreach ($reviews_not_approved as $each) {
                    $i++;
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $each['product_name']; ?></td>
                    <td><?php echo $each['customer_name']; ?></td>
                    <td><?php echo $each['customer_email']; ?></td>
                    <td><?php echo $each['content']; ?></td>
                    <td><?php echo $each['time']; ?></td>
                    <td>
                        <a 
                            class="btn btn-primary btn-approve"
                            data-id="<?php echo $each['review_id']?>"
                        >
                            Duyệt
                        </a>
                        <a 
                            class="btn btn-danger btn-delete" 
                            data-id="<?php echo $each['review_id']?>"
                        >
                            Xóa
                        </a>
                    </td>
                </tr>
            <?php
                };
            ?>
        </tbody>
    </table>
    
    <h2>Đánh giá đã duyệt</h2>
    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Sản phẩm</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Nội dung</th>
                <th>Thời gian</th>
                <th>Tùy biến</th>
            </tr>
        </thead>
        <tbody style="font-size: 14px" id="reviews-approved">
            <?php 
                $i = 0;
                foreach ($reviews_approved as $each) {
                    $i++;
            ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $each['product_name']; ?></td>
                    <td><?php echo $each['customer_name']; ?></td>
                    <td><?php echo $each['customer_email']; ?></td>
                    <td><?php echo $each['content']; ?></td>
                    <td><?php echo $each['time']; ?></td>
                    <td>
                        <a 
                            class="btn btn-danger btn-delete" 
                            data-id="<?php echo $each['review_id']?>"
                        >
                            Xóa
                        </a>
                    </td>
                </tr>
            <?php
                };
            ?>
        </tbody>
    </table>
<script>
    let btnApproves = $('.btn-approve');
    btnApproves.each(function(index, btnApprove) {
        $(btnApprove).click(function() {
            let id = $(this).data('id');
            $.ajax({
                url: 'reviews-ajax.php',
                type: 'POST',
                data: {
                    id: id,
                    action: 'update',
                },
                dataType: 'text',
                success: function (data) {
                    $(btnApprove).parent().parent().remove();
                    $('#reviews-approved').html(data);
                }
            })
        })
    })

    let btnDeletes = $('.btn-delete');
    btnDeletes.each(function(index, btnDelete) {
        $(btnDelete).click(function() {
            let id = $(this).data('id');

            $.ajax({
                url: 'reviews-ajax.php',
                type: 'POST',
                data: {
                    id: id,
                    action: 'delete'
                },
                dataType: 'text',
                success: function(data) {
                    $(btnDelete).parent().parent().remove();
                }
            })
        })
    })
</script>

<?php 
    } 
    require_once './partials/footer.php';
?>

