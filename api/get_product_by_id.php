<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
require_once 'db_connect.php';

   $product_id = $_GET['product_id'];
  
    //SQL inner join query with 3 tables
         $query = "SELECT * FROM products INNER JOIN product_category ON products.product_category_id=product_category.product_category_id INNER JOIN
    suppliers ON suppliers.suppliers_id = products.product_supplier_id  INNER JOIN
    weight_unit ON weight_unit.weight_unit_id = products.product_weight_unit_id WHERE product_id='$product_id'";

        
        
        $result = mysqli_query($con, $query);
        $response = array();
        while( $row = mysqli_fetch_assoc($result) ){
            array_push($response, 
            array(
                'product_id'=>$row['product_id'], 
                'product_name'=>$row['product_name'], 
                'product_code'=>$row['product_code'], 
                'product_category_id'=>$row['product_category_id'],
                'product_category_name'=>$row['product_category_name'],
                'suppliers_name'=>$row['suppliers_name'],
                'product_supplier_id'=>$row['product_supplier_id'],
                'product_description'=>$row['product_description'],
                'product_buy_price'=>$row['product_buy_price'],
                'product_sell_price'=>$row['product_sell_price'],
                'product_weight'=>$row['product_weight'],
                'weight_unit_name'=>$row['weight_unit_name'],
                'weight_unit_id'=>$row['weight_unit_id'],
                'product_image'=>$row['product_image'],
                'product_stock'=>$row['product_stock']
                ) 
            );
        }
        echo json_encode($response);   
    


mysqli_close($con);

}

?>