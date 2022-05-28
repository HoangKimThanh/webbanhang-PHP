<?php 
    function insert_customer($conn, $name, $phone, $email, $province, $district, $ward, $address, $password) {
        $query = "INSERT INTO customers (name, phone, email, province, district, ward, address, password)
        VALUES ('$name', '$phone', '$email', '$province', '$district', '$ward', '$address', md5('$password'))
        ";

        $result = mysqli_query($conn, $query);

        if ($result) {
            unset($_SESSION['signup']);
            $query = "SELECT * FROM customers WHERE email = '$email'";
            $result = mysqli_query($conn, $query);
            $each = mysqli_fetch_array($result);
            $_SESSION['customer']['id'] = $each['id'];
            $_SESSION['customer']['name'] = $each['name'];
            $_SESSION['customer']['email'] = $each['email'];

            // $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
            
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                $protocol = 'https://';
            } else {
                $protocol = 'http://';
            }
            
            $order_filepath = $protocol . $_SERVER['HTTP_HOST'] . '/dat-hang';

            $last_site = $_SESSION['last_site'] ?? '';

            if ($last_site == $order_filepath) {
                unset($_SESSION['last_site']);
                header('Location: ./dat-hang');
                exit;
            }
            header('Location: ./trang-chu');
        }
    }

    function update_customer($conn, $id, $name, $phone, $province, $district, $ward, $address) {
        $query = "UPDATE customers SET
            name = '$name',
            phone = '$phone',
            province = '$province',
            district = '$district',
            ward = '$ward',
            address = '$address'
        WHERE id = '$id'
        ";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo '<script>alert("Cập nhật thành công")</script>';
        }
    }

    function check_email_customer($conn, $email) {
        $query = "SELECT * FROM customers WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            if (mysqli_num_rows($result) == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    function update_email_customer($conn, $id, $email) {
        $query = "UPDATE customers SET email = '$email' WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            unset($_SESSION['change_email']);
            return $result;
        }
    }

    function check_password_customer($conn, $id, $password) {
        $query = "SELECT * FROM customers WHERE id = '$id' AND password = md5('$password')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            if(mysqli_num_rows($result) == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    function update_password_customer($conn, $id, $password) {
        $query = "UPDATE customers SET password = md5('$password') WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            setcookie("email", '', -1, "/");
            setcookie("password", '', -1, "/");
            return $result;
        }
    }

    function login_customer($conn, $email, $password, $remember) {
        $query = "SELECT * FROM customers WHERE email = '$email' AND password = md5('$password') LIMIT 1";
        $result = mysqli_query($conn, $query);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows == 1) {
            $each = mysqli_fetch_array($result);
            $_SESSION['customer']['id'] = $each['id'];
            $_SESSION['customer']['name'] = $each['name'];
            $_SESSION['customer']['email'] = $each['email'];

            if ($remember) {
                setcookie("email", $email, time() + 30 * 86400, "/");
                setcookie("password", $password, time() + 30 * 86400, "/");
            } else {
                setcookie("email", '', -1, "/");
                setcookie("password", '', -1, "/");
            }

            // $protocol = stripos($_SERVER['SERVER_PROTOCOL'],'https') === 0 ? 'https://' : 'http://';
            
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                $protocol = 'https://';
            } else {
                $protocol = 'http://';
            }
            $order_filepath = $protocol . $_SERVER['HTTP_HOST'] . '/dat-hang';
            
            $last_site = $_SESSION['last_site'] ?? '';

            if ($last_site == $order_filepath) {
                
                unset($_SESSION['last_site']);
                header('Location: ./dat-hang');
                exit();
            }
            
            header('Location: ./trang-chu');
        }
        $_SESSION['message'] = 'Email đăng nhập hoặc mật khẩu không đúng!';
    }

    function get_customer_by_id($conn, $id) {
        $query = "SELECT * FROM customers WHERE id = '$id' LIMIT 1";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        }
    }

    function get_all_customers($conn) {
        $query = "SELECT * FROM customers";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        }
    }

    function delete_customer($conn, $id) {
        $query = "DELETE FROM customers WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        }
    }
?>