<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
        require_once 'db_connect.php';

  
     //set default time zone
  date_default_timezone_set("Asia/Dhaka");
  
  //get current timedate
  $current_time=date("h:i A");
  
  //get current date
  $current_date=date("Y-m-d");
  $current_year=$_GET['yearly'];  
  

        
        include('my_function.php');

        


         $jan=getMonthlyExpense('1',$current_year);
         $feb=getMonthlyExpense('2',$current_year);
         $mar=getMonthlyExpense('3',$current_year);
         $apr=getMonthlyExpense('4',$current_year);
         $may=getMonthlyExpense('5',$current_year);
         $jun=getMonthlyExpense('6',$current_year);
         $jul=getMonthlyExpense('7',$current_year);
         $aug=getMonthlyExpense('8',$current_year);
         $sep=getMonthlyExpense('9',$current_year);
         $oct=getMonthlyExpense('10',$current_year);
         $nov=getMonthlyExpense('11',$current_year);
         $dec=getMonthlyExpense('12',$current_year);
         
        
        
      
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
                'dec'=>$dec
                
                
                ) 
            );
        
        echo json_encode($response);   
    


mysqli_close($con);

}

?>