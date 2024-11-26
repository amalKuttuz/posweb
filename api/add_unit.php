<?php 



if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

        require_once 'db_connect.php';
        $unit_name = $_POST['unit_name'];
   
         $sql="SELECT * FROM weight_unit WHERE weight_unit_name='$unit_name'";
        
        $result =  mysqli_query($con,$sql);
        $num_rows =mysqli_num_rows($result);
        
        if($num_rows>0)
        {
           $response["value"] = "exists";
           echo json_encode($response);
        }
        
        else
        {

        $query = "INSERT INTO weight_unit (weight_unit_name) VALUES ('$unit_name')";

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