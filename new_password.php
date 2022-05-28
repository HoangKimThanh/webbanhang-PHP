<?php 
    $title = "Mật khẩu mới";
    require_once './partials/header.php';
    if (!isset($_SESSION['forgot_password'])) {
        header('Location: trang-chu');
        exit;
    }
?>

<?php 
    if (isset($_POST['newPassword']) && isset($_POST['newPasswordAgain'])
    && !empty($_POST['newPassword']) && !empty($_POST['newPasswordAgain'])) {
        $new_password = $_POST['newPassword'];
        $new_password_again = $_POST['newPasswordAgain'];

        if ($new_password == $new_password_again) {
            $email = $_SESSION['forgot_password']['email'];
            $query = "SELECT id FROM customers WHERE email = '$email'";
            // die($query);
            $result = mysqli_query($conn, $query);
            $id = mysqli_fetch_array($result)['id'];
            update_password_customer($conn, $id, $new_password);
            unset($_SESSION['forgot_password']);
            echo '<script>alert("Đổi mật khẩu thành công! Đăng nhập lại để tiếp tục!")</script>';
            header('Location: dang-nhap');
            exit;
        } else {
            echo '<script>alert("Mật khẩu sai hoặc mật khẩu nhập lại không đúng")</script>';
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
                    <div class="form-group">
                        <label for="newPassword">
                            Nhập mật khẩu mới:
                        </label>
                        <br>
                        <input title="Mật khẩu tối thiểu 8 ký tự bao gồm ít nhất 1 chữ hoa, 1 chữ số và 1 ký tự đặc biệt" type="password" name="newPassword" id="newPassword" value="">
                        <span class="form-message"></span>
                    </div>
                </div>
    
                <div class="col l-12 m-12 c-12" style="margin-bottom: 32px;">
                    <div class="form-group">
                        <label for="newPasswordAgain">
                            Nhập lại mật khẩu mới:
                        </label>
                        <br>
                        <input  type="password" name="newPasswordAgain" id="newPasswordAgain" value="">
                        <span class="form-message"></span>
                    </div>
                </div>
    
                <div class="col l-12 m-12 c-12">
                    <button class="btn" value="changePassword">Đổi mật khẩu</button>
                </div>
            </div>
            </form>
    
    </div>  
</div>

    <script src="./assets/js/validator.js"></script>
    <script>
        Validator({
        form: '#form',
        formGroupSelector: '.form-group',
        errorElement: '.form-message',
        rules: [
            Validator.isRequired('#newPassword', 'Vui lòng nhập mật khẩu'),
            Validator.isStrong('#newPassword', 'Mật khẩu yếu'),
            Validator.isRequired('#newPasswordAgain', 'Vui lòng nhập lại mật khẩu'),
            Validator.isConfirmed('#newPasswordAgain', function() {
                return document.querySelector('#form #newPassword').value;
            }, 'Mật khẩu nhập lại không chính xác'),
            
        ],
        })
    </script>

    <script src="http://cdn.jsdelivr.net/qtip2/2.2.1/jquery.qtip.js"></script>
    <script>
        $(document).ready(function () {
            $('input[title]').qtip();    
        });
        $('input[title]').qtip({
            content: $(':focus').prop('title'),
            show: 'focus',
            hide: 'blur'
        });
    </script>

<?php 
    require_once './partials/footer.php';
?>