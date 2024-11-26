<?php 



if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

   require_once 'db_connect.php';
   
    $email = $_POST['email'];
    $password = $_POST['password'];

        $sql="SELECT * FROM users WHERE email='$email' AND password='$password'";
        $sql2="SELECT * FROM shop WHERE shop_id=1";
        
        $result =  mysqli_query($con,$sql);
        $num_rows =mysqli_num_rows($result);
        
        
        $result2 =  mysqli_query($con,$sql2);
        $num_rows2 =mysqli_num_rows($result2);
        
       
        
    


 while($row2 = mysqli_fetch_array($result2))
  {
  
  $shop_name=$row2['shop_name'];
  $shop_contact=$row2['shop_contact'];
  $shop_email=$row2['shop_email'];  
  $shop_address=$row2['shop_address'];
  
  $tax=$row2['tax'];
  $currency_symbol=$row2['currency_symbol'];
  $shop_status=$row2['shop_status'];
  }


    
  while($row = mysqli_fetch_array($result))
  {
  
  $staff_name=$row['name'];
  $staff_id=$row['id'];
  
  $user_type=$row['user_type'];

  }

  
  
        if($num_rows>0 AND $num_rows2>0)
	
       {
        
        $response["name"] = $staff_name;
        $response["id"] = $staff_id;    
     
        $response["user_type"] = $user_type;  
        
        
        $response["value"] = "success";
        $response["message"] = "Login Successfull!";
        
        
        
        
        //shop info
        $response["shop_name"] = $shop_name;
        $response["shop_contact"] = $shop_contact;
        $response["shop_email"] = $shop_email;
        $response["shop_address"] = $shop_address;
        $response["tax"] = $tax;
        $response["currency_symbol"] = $currency_symbol;
        $response["shop_status"] = $shop_status;
        
        echo json_encode($response);
       }
       
       else {
            $response["value"] = "failure";
            $response["message"] ="Invalid cell or password! Try again!";
            echo json_encode($response);
        }
        
       
    

   

} else {
    $response["value"] = "failure";
    $response["message"] = "Oops! Try again!";
    echo json_encode($response);
}

//close db connection
 mysqli_close($con);

?>