<?php


function categoryName($category_id)
{

  global $con;
  $sql = mysqli_query($con, "SELECT * FROM product_category WHERE product_category_id='$category_id'");
  $category_data = mysqli_fetch_assoc($sql);
  $category_name = $category_data['product_category_name'];

  return $category_name;
}


function weightUnit($weight_unit_id)
{

  global $con;
  $sql = mysqli_query($con, "SELECT * FROM weight_unit WHERE weight_unit_id='$weight_unit_id'");
  $weight_unit_data = mysqli_fetch_assoc($sql);
  $weight_unit_name = $weight_unit_data['weight_unit_name'];
  return $weight_unit_name;
}


function supplierName($suppliers_id)
{

  global $con;
  $sql = mysqli_query($con, "SELECT * FROM suppliers WHERE suppliers_id='$suppliers_id'");
  $suppliers_data = mysqli_fetch_assoc($sql);
  $suppliers_name = $suppliers_data['suppliers_name'];
  return $suppliers_name;
}


function getTotalExpense()
{
  global $con;
//  $result = mysqli_query($con,"SELECT SUM('product_price') AS value_sum FROM order_details");
//  $row = mysqli_fetch_assoc($result);
//  $sum = $row['value_sum'];
  $sql = mysqli_query($con, "SELECT SUM(expense_amount) as total FROM expense");
  $row = mysqli_fetch_array($sql);
  $sum = $row['total'];

  return $sum;
}



function getExpenseByType($type)
{
    
    //set default time zone
  date_default_timezone_set("Asia/Dhaka");
  
  //get current timedate
  $current_time=date("h:i A");
  
  //get current date
  $current_date=date("Y-m-d");
  
  
  global $con;
  if($type=='daily'){
  $result = mysqli_query($con, "SELECT SUM(expense_amount) AS total FROM expense WHERE expense_date='$current_date'");
  }
  else if($type=='weekly')
  {
      
        
      //Minus 7 days from current date
      $fromDate = date("Y-m-d",strtotime("-7 days"));
 
       $result = mysqli_query($con, "SELECT SUM(expense_amount) AS total FROM expense WHERE  expense_date>='$fromDate' AND NOW() ");
  
  
  }
  
  else if($type=='all')
  {
       $result = mysqli_query($con, "SELECT SUM(expense_amount) as total FROM expense");
  
  }
  
  else if($type=='monthly')
  {
      $result = mysqli_query($con, "SELECT SUM(expense_amount) AS total FROM expense WHERE  MONTH(STR_TO_DATE(expense_date, '%Y-%m-%d')) = MONTH(NOW()) ");
  
  }
  
  else if($type=='yearly')
  {
     $result = mysqli_query($con, "SELECT SUM(expense_amount) AS total FROM expense WHERE   YEAR(STR_TO_DATE(expense_date, '%Y-%m-%d')) = YEAR(NOW()) ");
    
  }

  
  $row = mysqli_fetch_assoc($result);
  $sum = $row['total'];

  return $sum;
}






function getTotalOrderPrice()
{
  global $con;
  $result = mysqli_query($con, "SELECT SUM(product_price) AS value_sum FROM order_details");
  $row = mysqli_fetch_assoc($result);
  $sum = $row['value_sum'];

  return $sum;
}


function getOrderPriceByType($type,$year)
{
    
    //set default time zone
  date_default_timezone_set("Asia/Dhaka");
  
  //get current timedate
  $current_time=date("h:i A");
  
  //get current date
  $current_date=date("Y-m-d");
  
  
  global $con;
  if($type=='daily'){
      
  $result = mysqli_query($con, "SELECT SUM(product_price) AS value_sum FROM order_details WHERE  product_order_date='$current_date'");
  }
  else if($type=='weekly')
  {
      
        
      //Minus 7 days from current date
      $fromDate = date("Y-m-d",strtotime("-7 days"));
 
       $result = mysqli_query($con, "SELECT SUM(product_price) AS value_sum FROM order_details WHERE  product_order_date>='$fromDate' AND NOW() ");
  
  
  }
  
  else if($type=='all')
  {
    $result = mysqli_query($con, "SELECT SUM(product_price) AS value_sum FROM order_details WHERE  YEAR(STR_TO_DATE(product_order_date, '%Y-%m-%d')) = '$year'");
  
  
  }
  
  else if($type=='monthly')
  {
      $result = mysqli_query($con, "SELECT SUM(product_price) AS value_sum FROM order_details WHERE  MONTH(STR_TO_DATE(product_order_date, '%Y-%m-%d')) = MONTH(NOW()) ");
  
  }
  
  else if($type=='yearly')
  {
     $result = mysqli_query($con, "SELECT SUM(product_price) AS value_sum FROM order_details WHERE   YEAR(STR_TO_DATE(product_order_date, '%Y-%m-%d')) = YEAR(NOW()) ");
    
  }

  
  $row = mysqli_fetch_assoc($result);
  $sum = $row['value_sum'];

  return $sum;
}





function getDiscountPriceByType($type,$year)
{
    
    
     //set default time zone
  date_default_timezone_set("Asia/Dhaka");
  
  //get current timedate
  $current_time=date("h:i A");
  
  //get current date
  $current_date=date("Y-m-d");
  
  
  global $con;
  if($type=='daily'){
  $result = mysqli_query($con, "SELECT SUM(discount) AS value_sum FROM order_list WHERE  order_date='$current_date'");
  }
  
  else if($type=='all'){
 $result = mysqli_query($con, "SELECT SUM(discount) AS value_sum FROM order_list WHERE  YEAR(STR_TO_DATE(order_date, '%Y-%m-%d')) = '$year'");

  }
  
  
  else if($type=='weekly')
  {
      
        
      //Minus 7 days from current date
      $fromDate = date("Y-m-d",strtotime("-7 days"));
 
       $result = mysqli_query($con, "SELECT SUM(discount) AS value_sum FROM order_list WHERE  order_date>='$fromDate' AND NOW() ");
  
  
  }
  else if($type=='monthly')
  {
      $result = mysqli_query($con, "SELECT SUM(discount) AS value_sum FROM order_list WHERE  MONTH(STR_TO_DATE(order_date, '%Y-%m-%d')) = MONTH(NOW()) ");
  
  }
  
  else if($type=='yearly')
  {
     $result = mysqli_query($con, "SELECT SUM(discount) AS value_sum FROM order_list WHERE   YEAR(STR_TO_DATE(order_date, '%Y-%m-%d')) = YEAR(NOW()) ");
    
  }

  
  $row = mysqli_fetch_assoc($result);
  $sum = $row['value_sum'];

  return $sum;
}





function getTotalDiscount()
{
  global $con;
  $result = mysqli_query($con, "SELECT SUM(discount) AS value_discount FROM order_list");
  $row = mysqli_fetch_assoc($result);
  $total_discount = $row['value_discount'];
  return $total_discount;
}


function getTotalTax()
{
  global $con;
  $result = mysqli_query($con, "SELECT SUM(tax) AS value_tax FROM order_list");
  $row = mysqli_fetch_assoc($result);
  $total_tax = $row['value_tax'];

  return $total_tax;
}



function getTaxPriceByType($type,$year)
{
    
     //set default time zone
  date_default_timezone_set("Asia/Dhaka");
  
  //get current timedate
  $current_time=date("h:i A");
  
  //get current date
  $current_date=date("Y-m-d");
  
  
  
  global $con;
  
  if($type=='daily'){
  $result = mysqli_query($con, "SELECT SUM(tax) AS value_sum FROM order_list WHERE  order_date='$current_date'");
  }
  
  else if($type=='all'){
$result = mysqli_query($con, "SELECT SUM(tax) AS value_sum FROM order_list WHERE YEAR(STR_TO_DATE(order_date, '%Y-%m-%d')) = '$year' ");

  }
  
  
  else if($type=='weekly')
  {
      
        
      //Minus 7 days from current date
      $fromDate = date("Y-m-d",strtotime("-7 days"));
 
       $result = mysqli_query($con, "SELECT SUM(tax) AS value_sum FROM order_list WHERE  order_date>='$fromDate' AND NOW() ");
  
  
  }
  else if($type=='monthly')
  {
      $result = mysqli_query($con, "SELECT SUM(tax) AS value_sum FROM order_list WHERE  MONTH(STR_TO_DATE(order_date, '%Y-%m-%d')) = MONTH(NOW()) ");
  
  }
  
  else if($type=='yearly')
  {
     $result = mysqli_query($con, "SELECT SUM(tax) AS value_sum FROM order_list WHERE YEAR(STR_TO_DATE(order_date, '%Y-%m-%d')) = YEAR(NOW()) ");
    
  }

  
  $row = mysqli_fetch_assoc($result);
  $sum = $row['value_sum'];

  return $sum;
}




function getCurrency()
{
  global $con;
  $result = mysqli_query($con, "SELECT currency_symbol FROM shop WHERE shop_id=1 ");
  $row = mysqli_fetch_assoc($result);
  $currency = $row['currency_symbol'];

  return $currency;
}


//calculate total price in month
function getMonthlySalesAmount($month, $getYear)
{

  global $con;
  $totalCost = 0;

  $year = $getYear;


  $sql="SELECT * FROM order_list WHERE  MONTH(STR_TO_DATE(order_date,'%Y-%m-%d')) = '$month' AND YEAR(STR_TO_DATE(order_date,'%Y-%m-%d')) = '$year'";

 
  $result = mysqli_query($con, $sql);



  while ( $row = mysqli_fetch_array($result))
  {
    $cost=floatval($row['order_price']);
    $totalCost = $totalCost + $cost;
  }


  return $totalCost;

}





//calculate total price in month
function getMonthlyExpense($month, $getYear)
{

  global $con;
  $totalExpense = 0;

  $year = $getYear;


  $sql="SELECT * FROM expense WHERE  MONTH(STR_TO_DATE(expense_date,'%Y-%m-%d')) = '$month' AND YEAR(STR_TO_DATE(expense_date,'%Y-%m-%d')) = '$year'";

  $result = mysqli_query($con, $sql);

  while ( $row = mysqli_fetch_array($result))
  {
    $cost=floatval($row['expense_amount']);
    $totalExpense = $totalExpense + $cost;
  }

  return $totalExpense;

}





function time_elapsed_string($datetime, $full = false) {

  //set default time zone
  date_default_timezone_set("Asia/Dhaka");

  $now = new DateTime;
  $ago = new DateTime($datetime);
  $diff = $now->diff($ago);

  $diff->w = floor($diff->d / 7);
  $diff->d -= $diff->w * 7;

  $string = array(
    'y' => 'year',
    'm' => 'month',
    'w' => 'week',
    'd' => 'day',
    'h' => 'hour',
    'i' => 'minute',
    's' => 'second',
  );
  foreach ($string as $k => &$v) {
    if ($diff->$k) {
      $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
    } else {
      unset($string[$k]);
    }
  }

  if (!$full) $string = array_slice($string, 0, 1);
  return $string ? implode(', ', $string) . ' ago' : 'just now';
}


function getProductStock($product_id)
{

  global $con;
  $sql = mysqli_query($con, "SELECT * FROM products WHERE product_id='$product_id'");
  $product_data = mysqli_fetch_assoc($sql);
  $product_stock = $product_data['product_stock'];
  return $product_stock;
}



?>
