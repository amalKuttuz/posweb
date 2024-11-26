<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
        require_once 'db_connect.php';

         $shop_id = $_GET['shop_id'];
  
         $query = "SELECT * FROM shop  WHERE shop_id='$shop_id'";

        
        
        $result = mysqli_query($con, $query);
        $response = array();
        while( $row = mysqli_fetch_assoc($result) ){
            array_push($response, 
            array(
                'shop_id'=>$row['shop_id'], 
                'shop_name'=>$row['shop_name'], 
                'shop_contact'=>$row['shop_contact'], 
                'shop_email'=>$row['shop_email'], 
                'shop_address'=>$row['shop_address'],
                'tax'=>$row['tax']
                
                ) 
            );
        }
        echo json_encode($response);   
    


mysqli_close($con);

}

?>