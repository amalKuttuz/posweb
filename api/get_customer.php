<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
require_once 'db_connect.php';

   $search_text = $_GET['search_text'];
  
  if(strlen($search_text)>1)
  {
       $query = "SELECT * FROM customers  WHERE customer_name LIKE '%$search_text%'  OR customer_cell LIKE '%$search_text%'  OR customer_email LIKE '%$search_text%'   OR customer_address LIKE '%$search_text%'   ";
  }
  else
  {
         $query = "SELECT * FROM customers  ORDER BY customer_id DESC";
  }

        
        
        $result = mysqli_query($con, $query);
        $response = array();
        while( $row = mysqli_fetch_assoc($result) ){
            array_push($response, 
            array(
                'customer_id'=>$row['customer_id'], 
                'customer_name'=>$row['customer_name'], 
                'customer_cell'=>$row['customer_cell'], 
                'customer_address'=>$row['customer_address'], 
                'customer_email'=>$row['customer_email']
                ) 
            );
        }
        echo json_encode($response);   
    


mysqli_close($con);

}

?>