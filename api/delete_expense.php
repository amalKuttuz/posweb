<?php 

require_once 'db_connect.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    $expense_id = $_POST['expense_id'];
  

    $query = "DELETE FROM expense WHERE expense_id = '$expense_id' ";

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