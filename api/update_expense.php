<?php 



if ( $_SERVER['REQUEST_METHOD'] == 'POST' ){
    
    require_once 'db_connect.php';

    $id = $_POST['expense_id'];
    $expense_name=$_POST['expense_name'];
    $amount = $_POST['expense_amount'];
    $note = $_POST['expense_note'];
    $date = $_POST['expense_date'];
    $time = $_POST['expense_time'];

  

        $query = "UPDATE expense SET expense_name='$expense_name',expense_amount='$amount',expense_note='$note',expense_date='$date',expense_time='$time'   WHERE expense_id='$id'";

        if ( mysqli_query($con, $query) ){
            $response["value"] = "success";
            echo json_encode($response);
        } else {
            $response["value"] = "failure";
          
            echo json_encode($response);
        }
        
         mysqli_close($con);
    }

   



?>