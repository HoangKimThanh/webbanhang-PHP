<?php 
    require_once './partials/header.php';
    require_once '../functions/products.php';
    require_once '../functions/product_imgs.php';
?>
<?php 
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header('Location: product-show.php');
    } else {
        $id = $_GET['id'];
        delete_product_imgs($conn, $id);
        delete_product($conn, $id);
    }
?>