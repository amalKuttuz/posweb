<?php
 define('HOST','localhost');         //hostname
 define('USER','keramfvp_admin');     //username
 define('PASS','AMAL@2024');        //user password
 define('DB','keramfvp_smartpos');  //database name
 
 $con = mysqli_connect(HOST,USER,PASS,DB) or die('Unable to Connect');

?>