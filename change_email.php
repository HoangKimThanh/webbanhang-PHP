<?php  
    $title = "Đổi email";
    require_once './partials/header.php';
    require_once 'send_email.php';

    if (!$isLogged) {
        header('Location: ./trang-chu');
    }
    $customer_id = $_SESSION['customer']['id'];
?>

<?php 

    if (isset($_POST['submit']) && $_POST['submit'] == 'submit' 
    && isset($_POST['email']) && !empty($_POST['email']) 
    && isset($_SESSION['token']['change_email']) && isset($_POST['token'])) {
        if ($_SESSION['token']['change_email'] === $_POST['token']) {
            $customer_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
            $check_email = check_email_customer($conn, $customer_email);
            
            if ($check_email == false) {
                $_SESSION['change_email']['code'] = rand(10000, 99999);
                $code = $_SESSION['change_email']['code'];
                
                $_SESSION['change_email']['email'] = $customer_email;
                $action = 'change email';
                send_code($code, $customer_email, $action);
                header('Location: nhap-ma-xac-thuc');
                exit;
            } else {
                echo '<script>alert("Email đã tồn tại!")</script>';
            }
        }
        header('Location: doi-email');
        exit;
    }
?>

<div class="content">
    <div class="profile" style="margin: 100px;">
        <form method="post" id="form">
            <input type="hidden" name="token" value="<?php echo $token ?>">
            <?php 
                 $_SESSION['token']['change_email'] = $token;
            ?>
            <div class="row">
                <div class="col l-12 m-12 c-12">
                    Nhập email mới:
                    <input required type="email" name="email" id="email">
                </div>
    
                <div class="col l-12 m-12 c-12">
                    <button type="submit" name="submit" class="btn" value="submit">Đổi email</button>
                </div>
            </div>
        </form>
    </div>  

</div>

<script> 
    form.onsubmit = function() {
        if (email.value) {
            return true;
        } else {
            alert('Chua nhap email');
            return false;
        }
    }
</script>

<?php 
    require_once './partials/footer.php';
?>
