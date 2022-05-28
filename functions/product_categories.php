<?php 
    function insert_product_category($conn, $name) {
        $query = "INSERT INTO product_categories (name) VALUES('$name')";
        $result = mysqli_query($conn, $query);
        
        header('Location:product_categories-show.php');
        exit;
    }

    function get_all_product_categories($conn) {
        $query = "SELECT * FROM product_categories";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function get_product_category_by_id($conn, $id) {
        $query = "SELECT * FROM product_categories WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function update_product_category($conn, $id, $name) {
        $query = "UPDATE product_categories SET name = '$name' WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        
        header('Location:product_categories-show.php');
        exit;
    }

    function delete_product_category($conn, $id) {
        $query = "DELETE FROM product_categories WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        
        header('Location:product_categories-show.php');
        exit;
    }
?>