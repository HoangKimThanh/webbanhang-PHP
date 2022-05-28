<?php
    function insert_product($conn, $product_category_id, $name, $detail, $description, $old_price, $new_price, $image, $link_shopee, $featured) {
        $query = "INSERT INTO products (product_category_id, name, detail, description, old_price, new_price, image, link_shopee, featured)
        VALUES ('$product_category_id', '$name', '$detail', '$description', '$old_price', '$new_price', '$image', '$link_shopee', '$featured')";
        mysqli_query($conn, $query);

        $query = "SELECT id FROM products ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($conn, $query);
        $id = mysqli_fetch_array($result)['id'];
        
        return $id;
    }

    function get_all_products($conn) {
        $query = "SELECT products.*, product_categories.name AS product_category_name FROM products JOIN product_categories ON products.product_category_id = product_categories.id";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function get_products_by_product_category($conn, $product_category_id = 0, $product_per_page = 0, $offset = 0, $sort) {
        if($product_category_id == 0) {
            $query = "SELECT * FROM products ORDER BY new_price $sort LIMIT  $product_per_page OFFSET $offset ";
        } else {
            $query = "SELECT * FROM products WHERE product_category_id = '$product_category_id' ORDER BY new_price $sort LIMIT  $product_per_page OFFSET $offset ";
        }
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function get_product_by_id($conn, $id) {
        $query = "SELECT * FROM products WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function get_products_by_keyword($conn, $keyword) {
        $query = "SELECT * FROM products WHERE name LIKE '%$keyword%'";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function get_products_by_featured($conn) {
        $query = "SELECT * FROM products WHERE featured = '1'";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function count_products_by_product_category($conn, $product_category_id = 0) {
        if($product_category_id == 0) {
            $query = "SELECT count(*) FROM products";
        } else {
            $query = "SELECT count(*) FROM products WHERE product_category_id = '$product_category_id'";
        }

        $result = mysqli_query($conn, $query);
        $each = mysqli_fetch_array($result);
        $total_product = $each['count(*)'];
        return $total_product;
    }

    function update_product($conn, $id, $product_category_id, $name, $detail, $description, $old_price, $new_price, $image, $link_shopee, $featured) {
        $query = "UPDATE products SET
            product_category_id = '$product_category_id',
            name = '$name',
            detail = '$detail',
            description = '$description',
            old_price = '$old_price',
            new_price = '$new_price',
            image = '$image',
            link_shopee = '$link_shopee',
            featured = '$featured'
        WHERE id = '$id'";

        mysqli_query($conn, $query);

        header('Location: products-show.php');
    }

    function delete_product($conn, $id) {
        $query = "DELETE FROM products WHERE id = '$id'";
        mysqli_query($conn, $query);
        header('Location: products-show.php');
    }
?>