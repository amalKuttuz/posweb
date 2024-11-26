<?php 



if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
    
    require_once 'db_connect.php';

    $category_id = $_POST['category_id'];
  

    $query = "DELETE FROM product_category WHERE product_category_id = '$category_id' ";

        if ( mysqli_query($con, $query) ){
            $response["value"] = "success";
          
            echo json_encode($response);
        } else {
            $response["value"] = "failure";
         
            echo json_encode($response);
        }

    mysqli_close($con);

} else {
    $response["value"] = "failure";
    echo json_encode($response);
}

?>