<?php 
    function total_customer($conn) {
        $query = "SELECT COUNT(*) FROM customers";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $each = mysqli_fetch_array($result);
            return $each['COUNT(*)'];
        }
    }

    function total_invoice($conn) {
        $query = "SELECT COUNT(*) FROM invoices WHERE status = 3";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $each = mysqli_fetch_array($result);
            return $each['COUNT(*)'];
        }
    }

    function total_profit($conn) {
        $query = "SELECT SUM(total) FROM invoices WHERE status = 3";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $each = mysqli_fetch_array($result);
            return $each['SUM(total)'];
        }
    }

    function total_visitor($conn) {
        $query = "SELECT SUM(visitors) FROM page_views";   
        $result = mysqli_query($conn, $query);
        if ($result) {
            $each = mysqli_fetch_array($result);
            return $each['SUM(visitors)'];
        }
    }
?>