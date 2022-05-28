<?php 
    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    
    function is_unique_ip($conn, $ip, $date) {
        $query = "SELECT * FROM page_views WHERE ip_address = '$ip' AND DATE(date) = '$date'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if (mysqli_num_rows($result) === 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    function insert_page_view($conn, $ip, $date) {
        $query = "INSERT INTO page_views (date, ip_address) VALUES ('$date', '$ip')";
        // die($query);
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        }
        
    }

    function update_page_view($conn, $ip, $date) {
        $query = "UPDATE page_views SET visitors = visitors + 1 WHERE ip_address = '$ip' AND DATE(date) = '$date'";
        // die($query);
        $result = mysqli_query($conn, $query);
        if ($result) {
            return $result;
        }
    }
?>