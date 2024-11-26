<?php 


if ( $_SERVER['REQUEST_METHOD'] == 'GET' ){
require_once 'db_connect.php';

  $search_text = $_GET['search_text'];
  
   if(strlen($search_text)>1)
  {
      $query = "SELECT * FROM suppliers WHERE suppliers_name LIKE '%$search_text%'  OR suppliers_cell LIKE '%$search_text%'  OR suppliers_email LIKE '%$search_text%'   OR suppliers_address LIKE '%$search_text%' OR suppliers_contact_person LIKE '%$search_text%' ";
  }
  
  else
  {
   $query = "SELECT * FROM suppliers  ORDER BY suppliers_id DESC";   
  }
  
        
        
        
        
        $result = mysqli_query($con, $query);
        $response = array();
        while( $row = mysqli_fetch_assoc($result) ){
            array_push($response, 
            array(
                'suppliers_id'=>$row['suppliers_id'], 
                'suppliers_name'=>$row['suppliers_name'], 
                'suppliers_contact_person'=>$row['suppliers_contact_person'], 
                'suppliers_cell'=>$row['suppliers_cell'], 
                'suppliers_address'=>$row['suppliers_address'], 
                'suppliers_email'=>$row['suppliers_email']
                ) 
            );
        }
        echo json_encode($response);   
    


mysqli_close($con);

}

?>