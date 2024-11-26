<?php 

require_once 'db_connect.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    $invoice_id = $_POST['invoice_id'];
  

    $query = "DELETE FROM order_list WHERE invoice_id = '$invoice_id' ";
    $query2 = "DELETE FROM order_details WHERE invoice_id = '$invoice_id' ";

        if ( mysqli_query($con, $query) AND mysqli_query($con, $query2) ){
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