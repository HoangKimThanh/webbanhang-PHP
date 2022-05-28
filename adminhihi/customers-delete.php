<?php 
    require_once './partials/header.php';
    require_once '../functions/customers.php';
?>
<?php 
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $result = delete_customer($conn, $_GET['id']);
        header('Location: customers-show.php');
        exit;
    }
?>