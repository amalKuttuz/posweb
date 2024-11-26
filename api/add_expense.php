<?php 



if ($_SERVER['REQUEST_METHOD'] == 'POST' ){
    
    require_once 'db_connect.php';

    $expense_name=$_POST['expense_name'];
    $amount = $_POST['expense_amount'];
    $note = $_POST['expense_note'];
    $date = $_POST['expense_date'];
    $time = $_POST['expense_time'];

    $query = "INSERT INTO expense (expense_name, expense_amount, expense_note, expense_date, expense_time) VALUES ('$expense_name','$amount' ,'$note','$date','$time')";

        if (mysqli_query($con, $query) ){
            $response["value"] = "success";
            echo json_encode($response);
        } else {
            $response["value"] = "failure";
          
            echo json_encode($response);
        }
        
         mysqli_close($con);
    }

   


?>