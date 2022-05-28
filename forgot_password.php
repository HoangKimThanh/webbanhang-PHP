<?php  
    $title = "Quên mật khẩu";
    require_once './partials/header.php';
    require_once 'send_email.php';
?>

<?php 

    if (isset($_POST['submit']) && $_POST['submit'] == 'submit') {
        if (!(isset($_POST['email']) && !empty($_POST['email']))) {
            return;
        }
        $customer_email = $_POST['email'];
        $check_email = check_email_customer($conn, $customer_email);
        
        if ($check_email) {
            $_SESSION['forgot_password']['code'] = rand(10000, 99999);
            $code = $_SESSION['forgot_password']['code'];
            $_SESSION['forgot_password']['email'] = $customer_email;

            $action = 'forgot password';
            send_code($code, $customer_email, $action);
            header('Location: nhap-ma-xac-thuc');
            exit;
        } else {
            echo '<script>alert("Email không tồn tại!")</script>';
            header("Refresh:0");
            exit;
        }
    }
?>

<div class="content">
    <div class="profile" style="margin: 100px;">
        <form method="post" id="form">
            <div class="row">
                <div class="col l-12 m-12 c-12">
                    Nhập email tài khoản để lấy lại mật khẩu:
                    <input required type="email" name="email" id="email">
                </div>
    
                <div class="col l-12 m-12 c-12">
                    <button type="submit" name="submit" class="btn" value="submit">Gửi</button>
                </div>
            </div>
        </form>
    </div>  

</div>

<?php 
    require_once './partials/footer.php';
?>
