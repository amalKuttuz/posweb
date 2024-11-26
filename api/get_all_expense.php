<?php 
 
 if($_SERVER['REQUEST_METHOD']=='GET'){
 


  $getReportType= $_GET['type'];
  
    //set default time zone
  date_default_timezone_set("Asia/Dhaka");
  
  //get current timedate
  $current_time=date("h:i A");
  
  //get current date
  $current_date=date("Y-m-d");
  
  //for generate monthly report use date format ("Y/m/d") , others one not work;
 
 require_once('db_connect.php');
 
 
 //for monthly sql query
  if($getReportType=='monthly')
 
 {
  $sql =  "SELECT * FROM expense WHERE  MONTH(STR_TO_DATE(expense_date, '%Y-%m-%d')) = MONTH(NOW()) ";
  
 
 
 
}



 
 //for monthly sql query
  if($getReportType=='yearly')
 
 {
 $sql = "SELECT * FROM expense WHERE   YEAR(STR_TO_DATE(expense_date, '%Y-%m-%d')) = YEAR(NOW()) ORDER BY expense_id DESC";
     
}



 //for monthly sql query
  if($getReportType=='all')
 
 {
 
     $sql = "SELECT * FROM expense  ORDER BY expense_id DESC";
 
}




  //for weekly sql query
else if($getReportType=='weekly')
{

 
 
 //Minus 7 days from current date
 $fromDate = date("Y-m-d",strtotime("-7 days"));
 
   $sql =  "SELECT * FROM expense WHERE  expense_date>='$fromDate' AND NOW() ORDER BY expense_id DESC";
  

}


 
   //for daily sql query
  else if($getReportType=='daily')
   {

     
      $sql="SELECT * FROM expense WHERE  expense_date='$current_date' ORDER BY expense_id DESC";
   }



 

 $r = mysqli_query($con,$sql);
 
 
 $response = array();


while($row = mysqli_fetch_array($r))
        {
		
		//Pushing msg and date in the blank array created 
		array_push($response,array(
		              
		        'expense_id'=>$row['expense_id'], 
                'expense_name'=>$row['expense_name'], 
                'expense_note'=>$row['expense_note'], 
                'expense_amount'=>$row['expense_amount'], 
                'expense_date'=>$row['expense_date'],
                'expense_time'=>$row['expense_time']
           
		));
	}
 
  echo json_encode($response);   
 
 mysqli_close($con);
 
 }