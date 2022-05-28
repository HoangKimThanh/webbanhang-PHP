<?php 
    $filepath = realpath(dirname(__FILE__));
    require_once $filepath . '/../send_email.php';
    /**
     * 0: Chờ xử lý
     * 1: Chuẩn bị giao
     * 2: Đang giao
     * 3: Đã giao
     */
?>
<?php 
    function insert_invoice($conn, $customer_id, $receiver_name, $receiver_email, $receiver_phone, $receiver_province, $receiver_district,
     $receiver_ward, $receiver_address, $status, $cart, $payment = 'cash') {
        $total = 0;
        $sql_insert_invoice_details = '';

        $id = time() . '1' . uniqid();

        foreach($cart as $each) {
            $total += $each['new_price'] * $each['quantity'];
            $product_id = $each['id'];
            $quantity = $each['quantity'];
            $price = $each['new_price'];
            $sql_insert_invoice_details .= "INSERT INTO invoice_details (invoice_id, product_id, quantity, price) 
            VALUES('$id', '$product_id', '$quantity', '$price');";
        }

        $query = "INSERT INTO invoices
        (id, customer_id, receiver_name, receiver_phone, receiver_email, receiver_province, receiver_district, receiver_ward, receiver_address, total, payment, status)
        VALUES('$id', '$customer_id', '$receiver_name', '$receiver_phone', '$receiver_email', '$receiver_province', '$receiver_district', '$receiver_ward', '$receiver_address', '$total', '$payment', '$status')
        ";

        $_SESSION['after_pay'] = ['invoice' => $query, 'invoice_details' => $sql_insert_invoice_details];
        $_SESSION['after_pay']['invoice_id'] = $id;
        $_SESSION['after_pay']['receiver_email'] = $receiver_email;

        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https://' : 'http://';

        switch ($payment) {
            case 'vnpay':
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                /*
                * To change this license header, choose License Headers in Project Properties.
                * To change this template file, choose Tools | Templates
                * and open the template in the editor.
                */
                
                $vnp_TmnCode = "JIV6PH2Z"; //Website ID in VNPAY System
                $vnp_HashSecret = "WDGSWHTSEHXFKGRSMEDLFNDGXWJDTSUV"; //Secret key
                $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
                
                // $vnp_Returnurl = "http://laptopstore.com/after_pay.php";
                $vnp_Returnurl = $protocol . $_SERVER['HTTP_HOST'] . '/' . 'after_pay.php';

                $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
                //Config input format
                //Expire
                $startTime = date("YmdHis");
                $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));
                
                $vnp_TxnRef = $id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
                $vnp_OrderInfo = 'Thanh toán đơn hàng tại LaptopStore';
                $vnp_OrderType = 'billpayment';
                $vnp_Amount = $total * 100;
                $vnp_Locale = 'vn';
                $vnp_BankCode = 'NCB';
                $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
                //Add Params of 2.0.1 Version
                $vnp_ExpireDate = $expire;

                $inputData = array(
                    "vnp_Version" => "2.1.0",
                    "vnp_TmnCode" => $vnp_TmnCode,
                    "vnp_Amount" => $vnp_Amount,
                    "vnp_Command" => "pay",
                    "vnp_CreateDate" => date('YmdHis'),
                    "vnp_CurrCode" => "VND",
                    "vnp_IpAddr" => $vnp_IpAddr,
                    "vnp_Locale" => $vnp_Locale,
                    "vnp_OrderInfo" => $vnp_OrderInfo,
                    "vnp_OrderType" => $vnp_OrderType,
                    "vnp_ReturnUrl" => $vnp_Returnurl,
                    "vnp_TxnRef" => $vnp_TxnRef,
                    "vnp_ExpireDate"=>$vnp_ExpireDate,
                );
                
                if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                    $inputData['vnp_BankCode'] = $vnp_BankCode;
                }
                
                ksort($inputData);
                $query = "";
                $i = 0;
                $hashdata = "";
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                    } else {
                        $hashdata .= urlencode($key) . "=" . urlencode($value);
                        $i = 1;
                    }
                    $query .= urlencode($key) . "=" . urlencode($value) . '&';
                }
                
                $vnp_Url = $vnp_Url . "?" . $query;
                if (isset($vnp_HashSecret)) {
                    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                }
                $returnData = array('code' => '00'
                    , 'message' => 'success'
                    , 'data' => $vnp_Url);
                    header('Location: ' . $vnp_Url);
                    // if (isset($_POST['submit'])) {
                    //     header('Location: ' . $vnp_Url);
                    //     die();
                    // } else {
                    //     echo json_encode($returnData);
                    // }
                    // vui lòng tham khảo thêm tại code demo
                    break;

            case 'momo':
                function execPostRequest($url, $data){
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json',
                            'Content-Length: ' . strlen($data))
                    );
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                    //execute post
                    $result = curl_exec($ch);
                    //close connection
                    curl_close($ch);
                    return $result;
                }
    
                $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
    
    
                $partnerCode = 'MOMOBKUN20180529';
                $accessKey = 'klm05TvNBzhg7h7j';
                $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
    
                $orderInfo = "Thanh toán qua mã QR MoMo";
                $amount = $total;
                $orderId = $id;

                
                // $redirectUrl = "http://laptopstore.com/order.php";
                $redirectUrl = $protocol . $_SERVER['HTTP_HOST'] . '/' . 'order.php';
                
                $ipnUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
                $extraData = "";
    
                $requestId = time() . "";
                $requestType = "captureWallet";
                // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
                //before sign HMAC SHA256 signature

                $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
                $signature = hash_hmac("sha256", $rawHash, $secretKey);
                $data = array('partnerCode' => $partnerCode,
                    'partnerName' => "Test",
                    "storeId" => "MomoTestStore",
                    'requestId' => $requestId,
                    'amount' => $amount,
                    'orderId' => $orderId,
                    'orderInfo' => $orderInfo,
                    'redirectUrl' => $redirectUrl,
                    'ipnUrl' => $ipnUrl,
                    'lang' => 'vi',
                    'extraData' => $extraData,
                    'requestType' => $requestType,
                    'signature' => $signature);
                $result = execPostRequest($endpoint, json_encode($data));
                $jsonResult = json_decode($result, true);  // decode json
    
                //Just a example, please check more in there
    
                header('Location: ' . $jsonResult['payUrl']);
                exit;
                break;

            case 'ATM momo':
                function execPostRequest($url, $data) {
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json',
                            'Content-Length: ' . strlen($data))
                    );
                    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
                    //execute post
                    $result = curl_exec($ch);
                    //close connection
                    curl_close($ch);
                    return $result;
                }

                $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

                $partnerCode = 'MOMOBKUN20180529';
                $accessKey = 'klm05TvNBzhg7h7j';
                $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
                $orderInfo = "Thanh toán qua ATM MoMo";
                $amount = $total;
                $orderId = $id;

                $redirectUrl = $protocol . $_SERVER['HTTP_HOST'] . '/' . 'after_pay.php';

                // $redirectUrl = "http://laptopstore.com/after_pay.php";
                $ipnUrl = "https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b";
                $extraData = "";

                $requestId = time() . "";
                $requestType = "payWithATM";
                // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
                //before sign HMAC SHA256 signature
                $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
                $signature = hash_hmac("sha256", $rawHash, $secretKey);
                $data = array('partnerCode' => $partnerCode,
                    'partnerName' => "Test",
                    "storeId" => "MomoTestStore",
                    'requestId' => $requestId,
                    'amount' => $amount,
                    'orderId' => $orderId,
                    'orderInfo' => $orderInfo,
                    'redirectUrl' => $redirectUrl,
                    'ipnUrl' => $ipnUrl,
                    'lang' => 'vi',
                    'extraData' => $extraData,
                    'requestType' => $requestType,
                    'signature' => $signature);
                $result = execPostRequest($endpoint, json_encode($data));
                $jsonResult = json_decode($result, true);  // decode json

                //Just a example, please check more in there

                header('Location: ' . $jsonResult['payUrl']);
                exit;
                break;
            default:
                $result = mysqli_query($conn, $query);
                if ($result) {
                    $result_multi= mysqli_multi_query($conn, $sql_insert_invoice_details);
                    if ($result_multi) {
                        send_email($id, $receiver_email);
                        unset($_SESSION['cart']);
                        unset($_SESSION['after_pay']);
                        header('Location: cam-on?invoice_id=' . $id);
                        exit;
                    }
                }
                break;
        }

    }

    function get_invoice_by_id($conn, $id) {
        $query = "SELECT * FROM invoices WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        }
    }

    function get_invoices_by_customer_id($conn, $customer_id) {
        $query = "SELECT * FROM invoices WHERE customer_id = '$customer_id' ORDER BY time";
        $resuslt = mysqli_query($conn, $query);
        if ($resuslt) {
            return $resuslt;
        }
    }

    function get_invoice_details_by_id($conn, $id) {
        $query = "SELECT * FROM invoice_details JOIN products ON invoice_details.product_id = products.id WHERE invoice_id = '$id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        }
    }

    function get_all_invoices($conn) {
        $query = "SELECT * FROM invoices ORDER BY status asc, time desc";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        }
    }

    function update_invoice($conn, $id, $status) {
        $query = "UPDATE invoices SET status = '$status' WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        }
    }

    function delete_invoice($conn, $id) {
        $query = "DELETE FROM invoice_details WHERE invoice_id = '$id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $query = "DELETE FROM invoices WHERE id = '$id'";
            $result = mysqli_query($conn, $query);
            if ($result) {
                return $result;
            }
        }

    }

    function get_new_invoices($conn) {
        $query = "SELECT COUNT(*) AS count FROM invoices WHERE status = 0";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $each = mysqli_fetch_array($result);
            return $each['count'];
        }
    }
?>