<?php 
    function login_admin($conn, $account, $password) {
        $query = "SELECT * FROM admins WHERE account = '$account' AND password = md5('$password')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                $_SESSION['admin']['account'] = $account;
                header('Location: ./index.php');
                exit;
            } else {
                header("Refresh:0");
                exit;
            }
        }
    }

    function update_account_admin($conn, $account, $new_account) {
        $query = "UPDATE admins SET account = '$new_account' WHERE account = '$account'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $_SESSION['admin']['account'] = $new_account;
            echo '<script>alert("Đổi tên tài khoản thành công!")</script>';
            header('Refresh:0');
            exit;
        }
    }

    function check_password_admin($conn, $account, $password) {
        $query = "SELECT * FROM  admins WHERE account = '$account' AND password = md5('$password')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    function update_password_admin($conn, $account, $password) {
        $query = "UPDATE admins SET password = md5('$password') WHERE account = '$account'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        }
    }
?>