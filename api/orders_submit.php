<?php 


if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
    
    
require_once 'db_connect.php';
include ('../my_function.php');


//Get JSON posted by Android Application

 
  $json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);


$invoice_id=$data->invoice_id;
$order_date=$data->order_date;
$order_time=$data->order_time;
$order_type=$data->order_type;
$order_price=$data->order_price;
$order_payment_method=$data->order_payment_method;
$discount=$data->discount;
$tax=$data->tax;
$customer_name=$data->customer_name;
$served_by=$data->served_by;


//  $product_data=array();
//  $product_data=$data->{lines};
$product_data = isset($data->lines) ? $data->lines : [];

 
//Loop through an Array and insert data read from JSON into MySQL DB

    
  $result =  mysqli_query($con,"SELECT * FROM order_list WHERE  invoice_id='$invoice_id'");
  $num_rows =mysqli_num_rows($result);
  
  if($num_rows>0)
  {
   
    echo "exists";
 
   
  }
  
  
  else
  {
      

   
    $sql="INSERT INTO order_list (invoice_id,order_date,order_time,order_type,order_payment_method,order_price,discount,tax,customer_name,served_by) VALUES ('$invoice_id','$order_date','$order_time','$order_type','$order_payment_method','$order_price','$discount','$tax','$customer_name','$served_by') ";
    
    
  if( mysqli_query($con,$sql))
  {
      
     
      for ($i=0; $i < count($product_data); $i++) { 
     
      $product_id=$product_data[$i]->product_id;
      $product_name=$product_data[$i]->product_name;
      $product_image=$product_data[$i]->product_image;
      $product_price=$product_data[$i]->product_price;
      $product_weight=$product_data[$i]->product_weight;
      $product_order_date=$product_data[$i]->product_order_date;
      $product_qty=$product_data[$i]->product_qty;
      
      
      $sql2="INSERT INTO order_details (invoice_id,product_name,product_quantity,product_weight,product_price,product_order_date,product_id,product_image) VALUES ('$invoice_id','$product_name','$product_qty','$product_weight','$product_price','$product_order_date','$product_id','$product_image') ";
     
      mysqli_query($con,$sql2);
      
      
      
      $stock=getProductStock($product_id);
      $updated_stock=intval($stock)-intval($product_qty);
      $sql3="UPDATE products SET product_stock='$updated_stock' WHERE product_id='$product_id'";
      mysqli_query($con,$sql3);
      
 
          
      }
       
       
        echo "success"; 
       
  }
  else
  {
      echo "fail"; 
  }
   
 
  }
    

mysqli_close($con);

}

?>