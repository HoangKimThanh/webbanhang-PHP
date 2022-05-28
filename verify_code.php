<?php 
    $title = 'Nhập mã xác thực';
    require_once './partials/header.php';
?>
<?php 
    if (!isset($_SESSION['signup']) && !isset($_SESSION['change_email']) && !isset($_SESSION['forgot_password'])) {
        header('Location: trang-chu');
        exit;
    }
?>
<?php 
    if (isset($_POST['submit']) && $_POST['submit'] == 'submit' && isset($_POST['code']) && !empty($_POST['code'])) {
        $code = $_POST['code'];

        if (isset($_SESSION['signup'])) {
            if ($code == $_SESSION['signup']['code']) {
                $name = $_SESSION['signup']['data']['name'];
                $phone = $_SESSION['signup']['data']['phone'];
                $email = $_SESSION['signup']['data']['email'];
                $province = $_SESSION['signup']['data']['province'];
                $district = $_SESSION['signup']['data']['district'];
                $ward = $_SESSION['signup']['data']['ward'];
                $address = $_SESSION['signup']['data']['address'];
                $password = $_SESSION['signup']['data']['password'];
                insert_customer($conn, $name, $phone, $email, $province, $district, $ward, $address, $password);
            }
        }

        if (isset($_SESSION['change_email'])) {
            if ($code == $_SESSION['change_email']['code']) {
                $id = $_SESSION['customer']['id'];
                $email = $_SESSION['change_email']['email'];
                update_email_customer($conn, $id, $email);
                echo '<script>alert("Đổi email thành công!")</script>';
                header('Location: thong-tin-ca-nhan');
                exit;
            }
        } 

        if (isset($_SESSION['forgot_password'])) {
            if ($code == $_SESSION['forgot_password']['code']) {
                header('Location: mat-khau-moi');
                exit;
            }
        }
    }
?>
    <div class="content">
        <div class="main">
            <div class="grid wide">
                <form method="post">
                    Mã xác thực đã được gửi tới email của bạn: 
                    <br>
                    <label for="code">Nhập mã xác thực</label>
                    <input type="text" id="code" name="code">
                    <button type="submit" value="submit" name="submit" class="btn">Xác nhận</button>
                </form>

            </div>
        </div>
    </div>
<?php 
    require_once './partials/footer.php';
?>