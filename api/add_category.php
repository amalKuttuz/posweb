<?php 



if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){

        require_once 'db_connect.php';
        $category_name = $_POST['category_name'];
   
         $sql="SELECT * FROM product_category WHERE product_category_name='$category_name'";
        
        $result =  mysqli_query($con,$sql);
        $num_rows =mysqli_num_rows($result);
        
        if($num_rows>0)
        {
           $response["value"] = "exists";
           echo json_encode($response);
        }
        
        else
        {

        $query = "INSERT INTO product_category (product_category_name) VALUES ('$category_name')";

        if ( mysqli_query($con, $query) ){
            $response["value"] = "success";
            echo json_encode($response);
        } else {
            $response["value"] = "failure";
          
            echo json_encode($response);
        }
        
        }
    

    mysqli_close($con);

} else {
    $response["value"] = "failure";
    echo json_encode($response);
}

?>