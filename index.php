<?php
session_start();


$submit = "";

$status = "OK";
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email = $_POST['email'];
  $password = $_POST['password'];

//$id=md5($id1);
//$password=md5($password1);


  if (empty($email)) {
    $msg .= "<center><font  size='4px' face='Verdana' size='1' color='red'>Please Enter Your email. </font></center>";


    $status = "NOTOK";

  }


  if (empty($password)) {
    $msg .= "<center><font  size='4px' face='Verdana' size='1' color='red'>Please Enter Your password.</font></center>";

    $status = "NOTOK";
  }

  if ($status == "OK") {

    include('db_connect.php');


//   include('db_connect.php');

    $result = mysqli_query($con, "SELECT * FROM users WHERE email='$email' and password='$password'");

    $count = mysqli_num_rows($result);

    if ($count == 1) {

      $row = mysqli_fetch_array($result);

      $_SESSION['email'] = $row['email'];
      $_SESSION['key']=mt_rand(1000,9999);
      $_SESSION['user_type'] = $row['user_type'];


      header("location:dashboard.php");
    } else {


      $msg = "<center><font  size='4px' face='Verdana' size='1' color='red'>Wrong Email or Password !!!.</font></center>";

    }
  }

}


?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Smart POS | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Smart POS</b><br>Admin Panel
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="index.php" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div>

          <!-- /.col -->
          <div>
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->

        <?php
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "<div  align='center'>" . $msg . "</div";
          }
          ?>

        </div>
      </form>


    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>
