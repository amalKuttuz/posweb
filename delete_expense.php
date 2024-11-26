<?php
session_start();
if (isset($_SESSION['email']) AND isset($_SESSION['user_type']) AND isset($_SESSION['key']) )
	echo " ";
else {
	header("location:index.php");

}

include ('db_connect.php');

$id=$_GET['id'];

$delete=mysqli_query($con,"DELETE FROM expense  WHERE expense_id='$id'");

if($delete)
{
	echo "<script>alert('Expense Deleted!')</script>";
	echo "<script>window.open('expense.php','_self')</script>";
}

else
{
	echo "<script>alert('Failed!')</script>";
	echo "<script>window.open('expense.php','_self')</script>";
}


?>
