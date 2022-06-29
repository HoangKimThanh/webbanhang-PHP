<?php 
    require_once './partials/header.php';
    require_once './partials/sidenav.php';
    require_once './admin.php';


    $query = "SELECT * FROM admins WHERE id = 1";
    $result = mysqli_query($conn, $query);
    $account = mysqli_fetch_array($result);

    if (isset($_POST['submit']) && $_POST['submit'] == 'submit') {
        if (isset($_POST['account']) && !empty($_POST['account'])) {
            $new_account = $_POST['account'];

            $account = $_SESSION['admin']['account'];
            update_account_admin($conn, $account, $new_account);
        }
    }
?>
    <div class="row">
        <div class="col col-xl-12 col-md-12">
            <form action="" method="post">
                <label for="account">Tên tài khoản</label>
                <br>
                <input style="margin: 12px 0" type="text" id="account" name="account" value=<?php echo $account['account'] ?>>
                <br>
                <button class="btn btn-primary" type="submit" name="submit" value="submit">Cập nhập tên tài khoản</button>
            </form>
        </div>

        <div class="col col-xl-12 col-md-12" style="margin-top: 32px">
            <a href="change_password.php" class="btn btn-primary">Đổi mật khẩu</a>
        </div>
    </div>
    <br>

<?php 
    require_once './partials/footer.php';
?>