<?php 


if ($_SERVER['REQUEST_METHOD'] == 'GET' ){
require_once 'db_connect.php';

   $search_text = $_GET['search_text'];
  
  if(strlen($search_text)>1)
  {
       $query = "SELECT * FROM weight_unit  WHERE weight_unit_name LIKE '%$search_text%'";
  }
  else
  {
         $query = "SELECT * FROM weight_unit  ORDER BY weight_unit_id DESC";
  }

        
        
        $result = mysqli_query($con, $query);
        $response = array();
        while( $row = mysqli_fetch_assoc($result) ){
            array_push($response, 
            array(
                'weight_unit_id'=>$row['weight_unit_id'], 
                'weight_unit_name'=>$row['weight_unit_name'], 
                
                ) 
            );
        }
        echo json_encode($response);   
    


mysqli_close($con);

}

?>