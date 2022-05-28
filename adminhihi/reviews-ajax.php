<?php 
    require_once '../database/database.php';
    require_once '../functions/reviews.php';
?>
<?php 
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $action = $_POST['action'];
        
        switch ($action) {
            case 'update':
                $result = update_review($conn, $id);
                $reviews_approved = get_reviews_approved($conn);
                $str = '';
                $i = 0;
                foreach ($reviews_approved as $review) {
                    $i++;
                    $str .= '<tr>
                    <td>' . $i . '</td>
                    <td>' . $review['product_name'] . '</td>
                    <td>' . $review['customer_name'] . '</td>
                    <td>' . $review['customer_email'] . '</td>
                    <td>' . $review['content'] . '</td>
                    <td>' . $review['time'] . '</td>
                    <td>
                        <a 
                            class="btn btn-danger btn-delete" 
                            data-id="' . $review['id'] .'"
                            href="customers-delete.php?id=' . $review['id'] . '"
                        >
                            Xóa
                        </a>
                    </td>
                </tr>';
                }
                echo $str;
                break;
            
            case 'delete':
                delete_review($conn, $id);
                break;
            
            default:
                # code...
                break;
        }
    }
?>