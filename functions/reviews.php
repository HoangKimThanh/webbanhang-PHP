<?php 
    /**
     * 0: chưa duyệt
     * 1: đã duyệt
     */
    function insert_review($conn, $product_id, $customer_id, $customer_name, $customer_email, $content) {
        $query = "INSERT INTO reviews (product_id, customer_id, customer_name, customer_email, content)
        VALUES('$product_id', '$customer_id' , '$customer_name', '$customer_email', '$content')
        ";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        }
    }

    function get_reviews_by_product_id($conn, $product_id) {
        $query = "SELECT * FROM reviews WHERE product_id = $product_id and status = 1";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        }
    }

    function get_reviews_not_approved($conn) {
        $query = "SELECT *, reviews.id AS review_id, products.name AS product_name 
        FROM reviews JOIN products ON reviews.product_id = products.id 
        WHERE status = 0
        ORDER BY time DESC";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        }
    }

    function get_reviews_approved($conn) {
        $query = "SELECT *, reviews.id AS review_id, products.name AS product_name 
        FROM reviews JOIN products ON reviews.product_id = products.id 
        WHERE status = 1
        ORDER BY time DESC";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        }
    }

    function update_review($conn, $id) {
        $query = "UPDATE reviews SET status = 1 WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        }
    }

    function delete_review($conn, $id) {
        $query = "DELETE FROM reviews WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        }
    }

    function get_new_reviews($conn) {
        $query = "SELECT COUNT(*) AS count FROM reviews WHERE status = 0";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $each = mysqli_fetch_array($result);
            return $each['count'];
        }
    }
?>