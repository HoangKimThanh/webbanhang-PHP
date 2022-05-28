<?php

session_start();
ob_start();
require_once './database/database.php';
require_once './send_email.php';


if ((isset($_GET['vnp_ResponseCode']) && $_GET['vnp_ResponseCode'] == '00') || (isset($_GET['resultCode']) && $_GET['resultCode'] == '0')) {
    $query = $_SESSION['after_pay']['invoice'];
    $sql_insert_invoice_details = $_SESSION['after_pay']['invoice_details'];
        
    $result = mysqli_query($conn, $query);
    if ($result) {
        $result_multi= mysqli_multi_query($conn, $sql_insert_invoice_details);
        if ($result_multi) {
            $id = $_SESSION['after_pay']['invoice_id'];
            $email = $_SESSION['after_pay']['receiver_email'];
            send_email($id, $email);
            unset($_SESSION['cart']);
            unset($_SESSION['after_pay']);
            header('Location: cam-on?invoice_id=' . $id);
            exit;
        }
    }
} else {
    header('Location: dat-hang');
}
ob_end_flush();
?>