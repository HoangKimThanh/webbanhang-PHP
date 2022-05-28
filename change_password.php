<?php 
    $title = "Đổi mật khẩu";
    require_once './partials/header.php';
?>

<?php 
    if (isset($_POST['submit']) && $_POST['submit'] == 'submit') {
        if (isset($_POST['oldPassword']) && isset($_POST['newPassword']) && isset($_POST['newPasswordAgain'])
            && !empty($_POST['oldPassword']) && !empty($_POST['newPassword']) && !empty($_POST['newPasswordAgain'])
        ) {
            $id = $_SESSION['customer']['id'];
            $old_password = $_POST['oldPassword'];
            $new_password = $_POST['newPassword'];
            $new_password_again = $_POST['newPasswordAgain'];
            $check_password = check_password_customer($conn, $id, $old_password);

            if ($check_password && $new_password == $new_password_again) {
                update_password_customer($conn, $id, $new_password);
                echo '<script>alert("Đổi mật khẩu thành công! Đăng nhập lại để tiếp tục!")</script>';
                echo '<script>location.href="dang-xuat"</script>';
                exit;
            } else {
                echo '<script>alert("Mật khẩu sai hoặc mật khẩu nhập lại không đúng")</script>';
                header("Refresh:0");
                exit;
            }
        } else {
            header("Refresh:0");
            exit;
        }
    }
?>
<div class="content">
    <div class="profile" style="margin: 100px;">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" id="form">
            <span id="notice"></span>
            <div class="row">
                <div class="col l-12 m-12 c-12" style="margin-bottom: 32px;">
                    Nhập mật khẩu cũ:
                    <br>
                    <input required type="password" name="oldPassword" id="oldPassword" value=""> 
                </div>
    
                <div class="col l-12 m-12 c-12" style="margin-bottom: 32px;">
                    Nhập mật khẩu mới:
                    <br>
                    <input required type="password" name="newPassword" id="newPassword" value="">
                </div>
    
                <div class="col l-12 m-12 c-12" style="margin-bottom: 32px;">
                    Nhập lại mật khẩu mới:
                    <br>
                    <input required type="password" name="newPasswordAgain" id="newPasswordAgain" value="">
                </div>
    
                <div class="col l-12 m-12 c-12">
                    <button name="submit" type="submit" value="submit" class="btn" value="changePassword">Đổi mật khẩu</button>
                </div>
            </div>
            </form>
    
    </div>  
</div>


<script>
    form.onsubmit = function() {
        if (newPassword.value) {
            return true;
        } else {
            alert('Chua nhap mat khau');
            return false;
        }
    }
</script>

<?php 
    require_once './partials/footer.php';
?>