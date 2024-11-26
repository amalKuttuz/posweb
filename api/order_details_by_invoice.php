<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
require_once 'db_connect.php';

         $invoice_id = $_GET['invoice_id'];
   
        //  $sum_sql= "SELECT SUM(product_price) AS TotalPrice FROM order_details";
        //  $result2 = mysql_query('SELECT SUM(product_price) AS sub_total FROM order_details'); 
        //  $row = mysql_fetch_assoc($result2); 
        //  $sub_total = $row['sub_total'];
  
         $query = "SELECT * FROM order_details  WHERE invoice_id='$invoice_id' ORDER BY order_details_id DESC";

        
        
        $result = mysqli_query($con, $query);
        $response = array();
        while( $row = mysqli_fetch_assoc($result) ){
            array_push($response, 
            array(
                'order_details_id'=>$row['order_details_id'], 
                'invoice_id'=>$row['invoice_id'], 
                'product_name'=>$row['product_name'], 
                'product_quantity'=>$row['product_quantity'], 
                'product_weight'=>$row['product_weight'], 
                'product_price'=>$row['product_price'],
                'product_order_date'=>$row['product_order_date'],
                'product_image'=>$row['product_image']
                
                ) 
            );
        }
        echo json_encode($response);   
    


mysqli_close($con);

}

?>