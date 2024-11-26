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
 $sql="SELECT * FROM order_details WHERE  MONTH(STR_TO_DATE(product_order_date, '%Y-%m-%d')) = MONTH(NOW()) ORDER BY order_details_id DESC";
 
 
 
 
}



 
 //for monthly sql query
  if($getReportType=='yearly')
 
 {
 $sql="SELECT * FROM order_details WHERE  YEAR(STR_TO_DATE(product_order_date, '%Y-%m-%d')) = YEAR(NOW()) ORDER BY order_details_id DESC";
 
}



 //for monthly sql query
  if($getReportType=='all')
 
 {
 
    $sql = "SELECT * FROM order_details  ORDER BY order_details_id DESC";
 
}




  //for weekly sql query
else if($getReportType=='weekly')
{

 
 
 //Minus 7 days from current date
 $fromDate = date("Y-m-d",strtotime("-7 days"));
 
 $sql="SELECT * FROM order_details WHERE product_order_date>='$fromDate' AND NOW() ORDER BY order_details_id DESC";

}


 
   //for daily sql query
  else if($getReportType=='daily')
   {

     
      $sql="SELECT * FROM order_details WHERE  product_order_date='$current_date' ORDER BY order_details_id DESC";
   }



 

 $r = mysqli_query($con,$sql);
 
 
 $response = array();


while($row = mysqli_fetch_array($r))
        {
		
		//Pushing msg and date in the blank array created 
		array_push($response,array(
		              
		        'order_details_id'=>$row['order_details_id'], 
                'invoice_id'=>$row['invoice_id'], 
                'product_name'=>$row['product_name'], 
                'product_quantity'=>$row['product_quantity'], 
                'product_weight'=>$row['product_weight'], 
                'product_price'=>$row['product_price'],
                'product_order_date'=>$row['product_order_date'],
                'product_image'=>$row['product_image']
           
		));
	}
 
  echo json_encode($response);   
 
 mysqli_close($con);
 
 }