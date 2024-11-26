<?php 

require_once 'db_connect.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

    $id = $_POST['suppliers_id'];
    $name = $_POST['suppliers_name'];
    $contact_person = $_POST['suppliers_contact_person'];
    $cell = $_POST['suppliers_cell'];
    $email = $_POST['suppliers_email'];
    $address = $_POST['suppliers_address'];

    if ( $name == '' || $email == '' ){
    
     echo 'Please fill in all data!';

    } else {

        $query = "UPDATE suppliers SET suppliers_name='$name',suppliers_contact_person='$contact_person',suppliers_cell='$cell',suppliers_email='$email',suppliers_address='$address'WHERE suppliers_id='$id'";

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