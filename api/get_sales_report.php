<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
        require_once 'db_connect.php';

        $getReportType= $_GET['type'];
        include('my_function.php');

        

         $year=date("Y");

         $total_order_price=getOrderPriceByType($getReportType,$year);
         $total_discount=getDiscountPriceByType($getReportType,$year);
         $total_tax=getTaxPriceByType($getReportType,$year);

 
        
        
      
        $response = array();
    
            array_push($response, 
            array(
                'total_order_price'=>$total_order_price, 
                'total_tax'=>$total_tax, 
                'total_discount'=>$total_discount  
                
                
                ) 
            );
        
        echo json_encode($response);   
    


mysqli_close($con);

}

?>