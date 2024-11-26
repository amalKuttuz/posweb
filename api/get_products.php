<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
require_once 'db_connect.php';

   $search_text = $_GET['search_text'];
  
  if(strlen($search_text)>1)
  {
      
       
        $query = "SELECT * FROM products INNER JOIN
    weight_unit ON weight_unit.weight_unit_id = products.product_weight_unit_id WHERE product_name LIKE '%$search_text%' OR product_code LIKE '%$search_text%' ORDER BY product_id DESC";
  }
  else
  {
      

    //SQL inner join query with 3 tables
         $query = "SELECT * FROM products INNER JOIN
    weight_unit ON weight_unit.weight_unit_id = products.product_weight_unit_id ORDER BY product_id DESC";
         
       
  }

        
        
        $result = mysqli_query($con, $query);
        $response = array();
        while( $row = mysqli_fetch_assoc($result) ){
            array_push($response, 
            array(
                'product_id'=>$row['product_id'], 
                'product_name'=>$row['product_name'], 
                'product_code'=>$row['product_code'], 
                'product_category_id'=>$row['product_category_id'],
                'product_description'=>$row['product_description'],
                'product_sell_price'=>$row['product_sell_price'],
                'product_weight'=>$row['product_weight'],
                'weight_unit_name'=>$row['weight_unit_name'],
                'product_supplier_id'=>$row['product_supplier_id'],
                'product_image'=>$row['product_image'],
                'product_stock'=>$row['product_stock']
                ) 
            );
        }
        echo json_encode($response);   
    


mysqli_close($con);

}

?>