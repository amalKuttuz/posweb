<?php 

require_once 'db_connect.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    $customer_id = $_POST['customer_id'];
  

    $query = "DELETE FROM customers WHERE customer_id = '$customer_id' ";

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