<?php 
    function insert_product_imgs($conn, $product_id, $images) {
        if ($images['size'][0] > 0) {
            $arr_images_name = $images['name'];
            $arr_images_tmp_name = $images['tmp_name'];
            
            $images = [];

            for ($i = 0; $i < count($arr_images_name); $i++) {
                $images[$i] = ['name' => $arr_images_name[$i], 'tmp_name' => $arr_images_tmp_name[$i]];
            }

            $query = '';

            foreach ($images as $image) {
                $folder = '../assets/img/uploads/';
                $image_name = explode('.', $image['name'])[0] . '-' . time();
                $image_path = $folder . $image_name;
                move_uploaded_file($image['tmp_name'], $image_path);

                $query .= "INSERT INTO  product_imgs (product_id, images)
                VALUES ('$product_id', '$image_name');
                ";
            }
            mysqli_multi_query($conn, $query);

            header('Location: products-show.php');
            exit;
        }
    }

    function get_product_images_by_product_id($conn, $product_id) {
        $query = "SELECT * FROM product_imgs WHERE product_id = '$product_id'";
        $result = mysqli_query($conn, $query);
        return $result;
    }

    function delete_product_imgs($conn, $product_id) {
        $query = "DELETE FROM product_imgs WHERE product_id = '$product_id'";
        mysqli_query($conn, $query);
    }

    function update_product_imgs($conn, $product_id, $images) {
        if ($images['size'][0] > 0) {
            delete_product_imgs($conn, $product_id);
            insert_product_imgs($conn, $product_id, $images);
        }
    }
?>