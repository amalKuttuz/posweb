<?php 

require_once 'db_connect.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    $id = $_POST['customer_id'];
    $name = $_POST['customer_name'];
    $cell = $_POST['customer_cell'];
    $email = $_POST['customer_email'];
    $address = $_POST['customer_address'];

    if ( $name == '' || $email == '' ){
    
     echo 'Please fill in all data!';

    } else {

        $query = "UPDATE customers SET customer_name='$name',customer_cell='$cell',customer_email='$email',customer_address='$address' WHERE customer_id='$id'";

        if ( mysqli_query($con, $query) ){
            $response["value"] = "success";
            echo json_encode($response);
        } else {
            $response["value"] = "failure";
          
            echo json_encode($response);
        }
    }

    mysqli_close($con);

} else {
    $response["value"] = "failure";
    echo json_encode($response);
}

?>