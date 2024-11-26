<?php 



if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
    
    require_once 'db_connect.php';

    $unit_id = $_POST['unit_id'];
  

    $query = "DELETE FROM weight_unit WHERE weight_unit_id = '$unit_id' ";

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