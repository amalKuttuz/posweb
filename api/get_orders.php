<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
require_once 'db_connect.php';

   $search_text = $_GET['search_text'];
  
  if(strlen($search_text)>1)
  {
       $query = "SELECT * FROM order_list  WHERE invoice_id LIKE '%$search_text%' OR order_type LIKE '%$search_text%' OR order_payment_method LIKE '%$search_text%' OR customer_name LIKE '%$search_text%' ";
  }
  else
  {
         $query = "SELECT * FROM order_list  ORDER BY order_id DESC";
  }

        
        
        $result = mysqli_query($con, $query);
        $response = array();
        while( $row = mysqli_fetch_assoc($result) ){
            array_push($response, 
            array(
                'order_id'=>$row['order_id'], 
                'invoice_id'=>$row['invoice_id'],     
                'order_time'=>$row['order_time'], 
                'order_date'=>$row['order_date'], 
                'order_type'=>$row['order_type'],
                'order_price'=>$row['order_price'],
                'order_payment_method'=>$row['order_payment_method'],
                'discount'=>$row['discount'],
                'tax'=>$row['tax'], 
                'customer_name'=>$row['customer_name'], 
                'served_by'=>$row['served_by']
                ) 
            );
        }
        echo json_encode($response);   
    


mysqli_close($con);

}

?>