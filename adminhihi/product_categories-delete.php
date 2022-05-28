<?php
    require_once './partials/header.php';
    require_once '../functions/product_categories.php';

    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header('Location: product_category-show.php');
    } else  {
        $id = $_GET['id'];
        delete_product_category($conn, $id);
    }
?>