<?php 
    session_start();
    require_once '../database/database.php';
    require_once '../functions/invoices.php';

?>
<?php 
    if (isset($_POST['id']) && isset($_POST['action'])) {
        $action = $_POST['action'];
        $id = $_POST['id'];

        switch ($action) {
            case 'update':
                $status = $_POST['status'];
                update_invoice($conn, $id, $status);
                break;
            case 'read':
                $invoice_details = get_invoice_details_by_id($conn, $id);
                $str = '<table border="1">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>';
                $i = 0;
                foreach($invoice_details as $each) {
                    $i++;
                    $str .= '<tr>
                            <th>' . $i .'</th>
                            <th><img src="../assets/img/uploads/' . $each['image'] . '" alt=""></th>
                            <th>' . $each['name'] . '</th>
                            <th>' . $each['quantity'] . '</th>
                            <th>' . $each['price'] . '</th>
                        </tr>';
                }
                $str .= '</tbody>';  
                echo $str;        
                break;
            case 'delete':
                delete_invoice($conn, $id);
                break;
        }
    }
?>
