<?php 

require_once 'db_connect.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    $suppliers_id = $_POST['suppliers_id'];
  

    $query = "DELETE FROM suppliers WHERE suppliers_id = '$suppliers_id' ";

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