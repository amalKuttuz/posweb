<?php 

require_once 'db_connect.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    $name = $_POST['customer_name'];
    $cell = $_POST['customer_cell'];
    $email = $_POST['customer_email'];
    $address = $_POST['customer_address'];

    if ( $name == '' || $email == '' ){
    
     echo 'Please fill in all data!';

    } else {

        $query = "INSERT INTO customers (customer_name,customer_cell,customer_email,customer_address) VALUES ('$name','$cell' ,'$email','$address')";

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