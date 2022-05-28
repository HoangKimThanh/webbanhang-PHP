<?php 
    /**Line chart */
    require_once '../database/database.php';
    $data = [];
    $query = "SELECT date, sum(visitors) AS visitors FROM page_views GROUP BY date";
    $result = mysqli_query($conn, $query);

    foreach($result as $row) {
        $data['visitors'][] = $row;
    }

    /**Bar chart */
    $query = "SELECT MONTH(time) AS month, sum(total) AS revenue FROM invoices WHERE status = 3 GROUP BY MONTH";
    $result = mysqli_query($conn, $query);

    foreach ($result as $row) {
        $data['revenue'][] = $row;
    }

    /**Ajax */
    if(isset($_POST['period'])) {
        $period = $_POST['period'];

        switch ($period) {
            case '0':
                $query = "SELECT WEEKDAY(time) AS day, sum(total) AS revenue 
                FROM invoices 
                WHERE status = 3 AND WEEK(time) = WEEK( current_date ) - 1 AND YEAR( time) = YEAR( current_date )
                GROUP BY day";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) == 0) {
                    $data['compare']['last'] = null;
                } else {
                    foreach ($result as $row) {
                        $data['compare']['last'][$row['day']] = $row['revenue'];
                    }
                }


                $query = "SELECT WEEKDAY(time) AS day, sum(total) AS revenue 
                FROM invoices 
                WHERE status = 3 AND yearweek(time) = yearweek(now()) AND YEAR( time) = YEAR( current_date )
                GROUP BY day";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) == 0) {
                    $data['compare']['current'] = null;
                } else {
                    foreach ($result as $row) {
                        $data['compare']['current'][$row['day']] = $row['revenue'];
                    }
                }
                break;
            case '1':
                $query = "SELECT MONTH(time) AS date, sum(total) AS revenue 
                FROM invoices 
                WHERE status = 3 AND MONTH(time) = MONTH( current_date ) - 1 AND YEAR( time) = YEAR( current_date )
                GROUP BY date";
                $result = mysqli_query($conn, $query);
                
                if (mysqli_num_rows($result) == 0) {
                    $data['compare']['last'] = null;
                } else {
                    foreach ($result as $row) {
                        $data['compare']['last'][$row['date']] = $row['revenue'];
                    }
                }
                

                $query = "SELECT MONTH(time) AS date, sum(total) AS revenue 
                FROM invoices 
                WHERE status = 3 AND MONTH(time) = MONTH(now()) AND YEAR( time) = YEAR( current_date )
                GROUP BY date";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) == 0) {
                    $data['compare']['current'] = null;
                } else {
                    foreach ($result as $row) {
                        $data['compare']['current'][$row['date']] = $row['revenue'];
                    }
                }

                break;
            case '2':
                $query = "SELECT MONTH(time) AS month, sum(total) AS revenue 
                FROM invoices 
                WHERE status = 3 AND YEAR(time) = YEAR( current_date ) -1
                GROUP BY month";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) == 0) {
                    $data['compare']['current'] = null;
                } else {
                    foreach ($result as $row) {
                        $data['compare']['last'][$row['month']] = $row['revenue'];
                    }
                }

                $query = "SELECT MONTH(time) AS month, sum(total) AS revenue 
                FROM invoices 
                WHERE status = 3 AND YEAR(time) = YEAR( current_date )
                GROUP BY month";
                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) == 0) {
                    $data['compare']['current'] = null;
                } else {
                    foreach ($result as $row) {
                        $data['compare']['current'][$row['month']] = $row['revenue'];
                    }
                }
                
                break;
                        
            default:
                # code...
                break;
        }
    }

    echo json_encode($data);
?>