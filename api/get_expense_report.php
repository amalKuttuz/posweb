<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
        require_once 'db_connect.php';

        $getReportType= $_GET['type'];
        include('my_function.php');

        


         $total_expense_price=getExpenseByType($getReportType);
         
        
        
      
        $response = array();
    
            array_push($response, 
            array(
                'total_expense_price'=>$total_expense_price, 
               
                
                
                ) 
            );
        
        echo json_encode($response);   
    


mysqli_close($con);

}

?>