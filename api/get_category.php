<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
require_once 'db_connect.php';


         $query = "SELECT * FROM product_category  ORDER BY product_category_id DESC";
 
        $result = mysqli_query($con, $query);
        $response = array();
        while( $row = mysqli_fetch_assoc($result) ){
            array_push($response, 
            array(
                'product_category_id'=>$row['product_category_id'], 
                'product_category_name'=>$row['product_category_name'], 
                
                ) 
            );
        }
        echo json_encode($response);   
    


mysqli_close($con);

}

?>