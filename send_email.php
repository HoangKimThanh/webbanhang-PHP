<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$filepath = realpath(dirname(__FILE__));

require_once $filepath . '/./PHPMailer/src/Exception.php';
require_once $filepath . '/./PHPMailer/src/PHPMailer.php';
require_once $filepath . '/./PHPMailer/src/SMTP.php';

function send_email($id, $email) {
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';
    $url = $protocol . $_SERVER['HTTP_HOST'] . '/' . 'tra-cuu';
    try {
        //Server settings
        $mail->SMTPDebug = 2;// Enable verbose debug output
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();// gửi mail SMTP
        $mail->Host = 'smtp.gmail.com';// Set the SMTP server to send through
        $mail->SMTPAuth = true;// Enable SMTP authentication
        $mail->Username = 'phukienuit@gmail.com';// SMTP username
        $mail->Password = ''; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port = 587; // TCP port to connect to
        //Recipients
        $mail->setFrom('phukienuit@gmail.com', 'PhuKienUIT');
        // $mail->addAddress('joe@example.net', 'Joe User'); // Add a recipient
        $mail->addAddress($email); // Name is optional
        // $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('phukienuit@gmail.com');
        // $mail->addBCC('bcc@example.com');
        // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
        // Content
        $mail->isHTML(true);   // Set email format to HTML
        $mail->Subject = 'Cảm ơn quý khách đã đặt hàng tại PhuKienUITNhom10';
        $mail->Body = 
        '<p>Mã đơn hàng của quý khách là ' . $id . '. Dùng mã này để tra cứu đơn hàng tại <a href="' . $url .'?invoice_id=' . $id . '">PhuKienUITNhom10</a></p>';
        $mail->AltBody = 'Mã đơn hàng của quý khách là ' . $id . '. Dùng mã này để tra cứu đơn hàng tại PhuKienUITNhom10';
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}

function send_code($code, $email, $action) {
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 2;// Enable verbose debug output
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();// gửi mail SMTP
        $mail->Host = 'smtp.gmail.com';// Set the SMTP server to send through
        $mail->SMTPAuth = true;// Enable SMTP authentication
        $mail->Username = 'phukienuit@gmail.com';// SMTP username
        $mail->Password = 'kavxxdjkkdeydhlt'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;// Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port = 587; // TCP port to connect to
        //Recipients
        $mail->setFrom('phukienuit@gmail.com', 'PhuKienUITNhom10');
        // $mail->addAddress('joe@example.net', 'Joe User'); // Add a recipient
        $mail->addAddress($email); // Name is optional
        $mail->addCC('phukienuit@gmail.com');
        // $mail->addReplyTo('info@example.com', 'Information');
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');
        // Attachments
        // $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
        // Content
        $mail->isHTML(true);   // Set email format to HTML

        switch ($action) {
            case 'verify email':
                $mail->Subject = 'Xác thực đăng ký tài khoản mới tại PhuKienUITNhom10';
                break;
            
            case 'change email':
                $mail->Subject = 'Xác thực đổi tài khoản email tại PhuKienUITNhom10';
                break;
            case 'forgot password':
                $mail->Subject = 'Xác thực tạo mật khẩu mới khi quên mật khẩu tại PhuKienUITNhom10';
        }
        $mail->Body = 
        '<p>Mã xác thực của quý khách là ' . $code ;
        $mail->AltBody = 'Mã xác thực của quý khách là ' . $code;
        $mail->send();
    } catch (Exception $e) {
        return;
    }
}