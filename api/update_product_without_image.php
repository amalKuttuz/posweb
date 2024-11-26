<?php


if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
    
$response = array();

 $product_id =  $_POST['product_id'];
 $name =  $_POST['product_name'];
 $code =  $_POST['product_code'];
 $category_id =  $_POST['category_id'];
 $description =  $_POST['product_description'];
 $buy_price =  $_POST['product_buy_price'];
 $sell_price =  $_POST['product_sell_price'];
 $weight =$_POST['product_weight'];
 $weight_unit_id =  $_POST['product_weight_unit_id'];
 $suppliers_id =$_POST['suppliers_id'];
 $stock =  $_POST['product_stock'];

 
 
 

 //importing db_connect.php script 
 require_once('db_connect.php');
 
  $sql = "UPDATE products SET product_name='$name',product_code='$code',product_category_id=$category_id,product_description='$description',product_buy_price=$buy_price,product_sell_price=$sell_price,product_weight='$weight',product_weight_unit_id=$weight_unit_id,product_supplier_id=$suppliers_id,product_stock=$stock WHERE product_id=$product_id";
 
 

     if(mysqli_query($con,$sql))
     {
     $response["value"] = "success";
     echo json_encode($response);
     }
     else
     {
       
            $response["value"] = "failure";
            echo json_encode($response);
     }
 
   
     mysqli_close($con);
}

else
{

 $response["value"] = "failure";
 echo json_encode($response);
 echo json_encode($response);

}

?>