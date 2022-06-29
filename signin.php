<?php
    $title = 'Đăng nhập';
    require_once './partials/header.php';
?>
<?php 
    if (isset($_SESSION['customer']['id'])) {
        header('Location: ./trang-chu');
    }
?>
<?php 
    if (isset($_SERVER['HTTP_REFERER'])) {
        if (strpos($_SERVER['HTTP_REFERER'], 'dat-hang') > 0) {
            $_SESSION['last_site'] = $_SERVER['HTTP_REFERER'];
        }
    }
    
    if (isset($_POST['submit']) && $_POST['submit'] == 'submit' && isset($_POST['email']) && isset($_POST['password']) &&
     !empty($_POST['password']) && !empty($_POST['email'])) {
        // $email = $_POST['email'];
        // $password = $_POST['password'];

        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $remember = isset($_POST['remember']) ? true : false;
        login_customer($conn, $email, $password, $remember);
    }
?>
        <!---------------------------------------- Content ---------------------------------------->
        <div class="content">
            <!---------------------------------------- Signin ---------------------------------------->
            <div class="main">
                <div class="sign signin">
                    <div class="grid wide">
                        <h3 class="sign__heading">Đăng nhập</h3>
                        <div class="row">
                            <div class="col l-6 m-6 c-12">
                                <div class="sign-left">
                                    <h4>Đăng nhập bằng tài khoản đã có:</h4>
                                    <p class="message"><span class="highlight"><?php if(isset($_SESSION['message'])) echo $_SESSION['message']; unset($_SESSION['message']);?></span></p>
                                    <form action="dang-nhap" method="post">
                                        <div class="row">
                                            <div class="col l-5 m-5 c-12">
                                                <label for="signin-email" class="">
                                                    Email của bạn:
                                                </label>
                                            </div>
        
                                            <div class="col l-7 m-7 c-12">
                                                <input value="<?php echo isset($_COOKIE['email']) ? $_COOKIE['email'] : '' ?>" required type="email" name="email" id="signin-email" placeholder="Email của bạn...">
                                            </div>
        
                                            <div class="col l-5 m-5 c-12">
                                                <label for="signin-password">
                                                    Mật khẩu:
                                                </label>
                                            </div>
        
                                            <div class="col l-7 m-7 c-12">
                                                <input value="<?php echo isset($_COOKIE['password']) ? $_COOKIE['password'] : '' ?>" required type="password" name="password" id="signin-password" placeholder="Mật khẩu của bạn...">
                                            </div>
            
                                            <div class="col l-5 m-5 c-12">
                                            </div>
        
                                            <div class="col l-7 m-7 c-12">
                                                <label for="sign-save">
                                                    <input type="checkbox" name="remember" id="sign-save" <?php if(isset($_COOKIE['email']) && $_COOKIE['password']) echo 'checked' ?>>
                                                    Ghi nhớ đăng nhập?
                                                </label>
                                            </div>
                                            
                                            <div class="col l-5 m-5 c-12">
                                            </div>
            
                                            <div class="col l-7 m-7 c-12">
                                                <a href="quen-mat-khau">Quên mật khẩu?</a>
                                            </div>
        
                                            <div class="col l-5 m-5 c-12">
                                            </div>
            
                                            <div class="col l-7 m-7 c-12">
                                                <button type="submit" name="submit" class="btn" value="submit">Đăng nhập</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
        
                            <div class="col l-6 m-6 c-12">
                                <div class="sign-right">
                                    <h4>Khách hàng mới của PhuKienHKT</h4>
                                    <p>
                                        Đăng ký ngay nếu bạn chưa có tài khoản trên phukienhkt.000webhostapp.com.
                                    </p>
        
                                    <p>
                                        Tạo tài khoản giúp bạn có trải nghiệm thú vị và quá trình mua hàng trở nên nhanh chóng hơn!
                                    </p>
                                    
                                    <a href="./dang-ky" class="btn">Đăng ký</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?php
    require_once './partials/footer.php';
?>