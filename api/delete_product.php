<?php 



if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    require_once 'db_connect.php';

    $product_id = $_POST['product_id'];
  

    $query = "DELETE FROM products WHERE product_id = '$product_id' ";

        if ( mysqli_query($con, $query) ){
            $response["value"] = "success";
          
            echo json_encode($response);
        } else {
            $response["value"] = "failure";
         
            echo json_encode($response);
        }

    mysqli_close($conn);

} else {
    $response["value"] = "failure";
    echo json_encode($response);
}

?>