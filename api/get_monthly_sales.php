<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
        require_once 'db_connect.php';

  
     //set default time zone
  date_default_timezone_set("Asia/Dhaka");
  
  //get current timedate
  $current_time=date("h:i A");
  
  //get current date
  $current_date=date("Y-m-d");
  $current_year= $_GET['yearly'];  
  
       
        include('my_function.php');

        
         $total_order_price=getOrderPriceByType('all',$current_year);
         $total_discount=getDiscountPriceByType('all',$current_year);
         $total_tax=getTaxPriceByType('all',$current_year);

        if(empty($total_tax))
        {
             $total_tax=0;
        }
 
        if(empty($total_order_price))
        {
             $total_order_price=0;
        }
        
       if(empty($total_discount))
        {
             $total_discount=0;
        }
        


         $jan=getMonthlySalesAmount('1',$current_year);
         $feb=getMonthlySalesAmount('2',$current_year);
         $mar=getMonthlySalesAmount('3',$current_year);
         $apr=getMonthlySalesAmount('4',$current_year);
         $may=getMonthlySalesAmount('5',$current_year);
         $jun=getMonthlySalesAmount('6',$current_year);
         $jul=getMonthlySalesAmount('7',$current_year);
         $aug=getMonthlySalesAmount('8',$current_year);
         $sep=getMonthlySalesAmount('9',$current_year);
         $oct=getMonthlySalesAmount('10',$current_year);
         $nov=getMonthlySalesAmount('11',$current_year);
         $dec=getMonthlySalesAmount('12',$current_year);
         
        
        
      
        $response = array();
    
            array_push($response, 
            array(
                'jan'=>$jan,
                'feb'=>$feb, 
                'mar'=>$mar, 
                'apr'=>$apr, 
                'may'=>$may,
                'jun'=>$jun,
                'jul'=>$jul,
                'aug'=>$aug,
                'sep'=>$sep,
                'oct'=>$oct,
                'sep'=>$sep,
                'oct'=>$oct,
                'nov'=>$nov,
                'dec'=>$dec,
                'total_order_price'=>$total_order_price, 
                'total_tax'=>$total_tax, 
                'total_discount'=>$total_discount
                ) 
            );
        
        echo json_encode($response);   
    


mysqli_close($con);

}

?>