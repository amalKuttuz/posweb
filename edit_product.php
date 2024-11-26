<?php
session_start();
if (isset($_SESSION['email']) AND isset($_SESSION['user_type']) AND isset($_SESSION['key']) )
    echo " ";
else {
    header("location:index.php");

}


if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $getid = $_GET['id'];
  include('db_connect.php');
  include('my_function.php');

  if (!empty($getid)) {
    $query = mysqli_query($con, "SELECT * FROM products WHERE product_id='$getid'");
    $row = mysqli_fetch_assoc($query);

    //call function
    $category_name = categoryName($row['product_category_id']);

    //call function
    $weight_unit_name = weightUnit($row['product_weight_unit_id']);
    //call function
    $suppliers_name = supplierName($row['product_supplier_id']);

  }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  include('db_connect.php');

  $product_id = $_POST['product_id'];
  $product_name = $_POST['product_name'];
  $product_code = $_POST['product_code'];
  $product_category_id = $_POST['product_category_id'];
  $product_supplier_id = $_POST['product_supplier_id'];
  $product_weight = $_POST['product_weight'];
  $product_weight_unit_id = $_POST['product_weight_unit_id'];
  $product_sell_price = $_POST['product_price'];
  $product_buy_price = $_POST['buy_price'];
  $product_stock = $_POST['product_stock'];
  $product_description = $_POST['product_description'];

  $product_image = $_POST['product_image'];


  $query = mysqli_query($con, "SELECT * FROM products WHERE product_id='$product_id'");
  $row = mysqli_fetch_assoc($query);


  //get file name
  $filename = basename($_FILES['uploadedfile']['name']);


  if (empty($filename)) {
    $newfilename = $product_image;
  } else {

    $sms_code = time();
    //generate random file name
    $temp = explode(".", $_FILES["uploadedfile"]["name"]);
    $newfilename = $sms_code . '.' . end($temp);
    move_uploaded_file($_FILES["uploadedfile"]["tmp_name"], "product_images/" . $newfilename);

  }

  if (mysqli_query($con, "UPDATE products SET product_name='$product_name',product_code='$product_code',product_category_id='$product_category_id',product_description='$product_description',product_buy_price='$product_buy_price',product_sell_price='$product_sell_price',product_weight='$product_weight',product_weight_unit_id='$product_weight_unit_id',product_supplier_id='$product_supplier_id',product_image='$newfilename',product_stock='$product_stock' WHERE product_id='$product_id'")) {
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () { swal.fire("Product Successfully Updated!","Done!","success");';
    echo '}, 500);</script>';

    echo '<script type="text/javascript">';
    echo "setTimeout(function () { window.open('products.php','_self')";
    echo '}, 1500);</script>';

  } else {// display the error message
    echo '<script type="text/javascript">';
    echo 'setTimeout(function () { swal.fire("ERROR!","Something Wrong!","error");';
    echo '}, 500);</script>';
  }


}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Edit Product</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <script src="plugins/jquery.min/jquery.min.js"></script>

  <!--Preloader-->
  <link rel="stylesheet" href="dist/css/preloader.css">
  <script src="dist/js/preloader.js"></script>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="plugins/sweetalert2/sweetalert2.min.css">
  <script src="plugins/sweetalert2/sweetalert2.min.js"></script>


  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">


  <!-- Bootstrap core CSS     -->
  <link href="plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="se-pre-con"></div>
<div class="wrapper">

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

    </ul>

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="dist/img/AdminLTELogo.png"
           alt="AdminLTE Logo"
           class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard

              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="customers.php" class="nav-link">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Customers

              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="suppliers.php" class="nav-link">
              <i class="nav-icon fas fa-people-carry"></i>
              <p>
                Suppliers

              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="category.php" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Products Category

              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="products.php" class="nav-link active">
              <i class="nav-icon fas fa-shopping-bag"></i>
              <p>
                Products

              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="orders.php" class="nav-link">
              <i class="nav-icon fas fa-sort-amount-up"></i>
              <p>
                Orders

              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="neworder.php" class="nav-link">
              <i class="nav-icon fas fa-sort-amount-up"></i>
              <p>
                POS

              </p>
            </a>
          </li> 
          <li class="nav-item">
            <a href="expense.php" class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>
                Expense
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>

              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="sales_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sales Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="expense_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Expense Report</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="sales_chart.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sales Chart </p>
                </a>
              </li>

              <li class="nav-item">
                <a href="expense_chart.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Expense Chart</p>
                </a>
              </li>

            </ul>


          </li>

          <li class="nav-item">
            <a href="products.php" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>

              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="shop_information.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Shop Information</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="all_users.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>All Users</p>
                </a>
              </li>
            </ul>

          </li>

          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-power-off"></i>
              <p>
                Logout
              </p>
            </a>
          </li>


        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">


        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">

          <!-- /.card -->

          <div class="card">
            <div class="card-header">

              <h3 class="card-title">Update product information</h3>

            </div>


            <form enctype="multipart/form-data" role="form" id="quickForm" method="post" action="edit_product.php">
              <div class="card-body">


                <div class="form-group">
                  <input type="hidden" name="product_id" class="form-control" id="exampleInputProductId"
                         value="<?php echo $row['product_id'] ?>">
                </div>

                <div class="form-group">
                  <label for="exampleInputProductName">Product Name</label>
                  <input type="text" name="product_name" class="form-control" id="exampleInputProductName"
                         value="<?php echo $row['product_name'] ?>">
                </div>


                <div class="form-group">
                  <label for="exampleInputProductCode">Product Code</label>
                  <input type="text" name="product_code" class="form-control" id="exampleInputProductCode"
                         value="<?php echo $row['product_code'] ?>">
                </div>


                <div class="form-group">

                  <div class="form-group">
                    <label for="exampleInputCategory">Product Category</label>
                    <select class="form-control" name="product_category_id" id="exampleInputCategory">
                      <?php echo "<option value='" . $row['product_category_id'] . "'>" . $category_name . "</option>"; ?>

                      <?php
                      include('db_connect.php');
                      $result = mysqli_query($con, "SELECT * FROM product_category");
                      while ($row2 = mysqli_fetch_array($result)) {
                        echo "<option value='" . $row2['product_category_id'] . "'>" . $row2['product_category_name'] . "</option>";

                      }
                      echo "</select>";

                      ?>
                  </div>
                </div>


                <div class="form-group">
                  <label for="exampleInputDescription">Product Description</label>
                  <input type="text" name="product_description" class="form-control" id="exampleInputDescription"
                         value="<?php echo $row['product_description'] ?>">
                </div>


               
                <div class="form-group">
                  <label for="exampleInputPrice">Product Buy Price</label>
                  <input type="number" name="buy_price" class="form-control" id="exampleInputPrice"
                         value="<?php echo $row['product_buy_price'] ?>">
                </div>
               
                <div class="form-group">
                  <label for="exampleInputPrice">Product Sell Price</label>
                  <input type="number" name="product_price" class="form-control" id="exampleInputPrice"
                         value="<?php echo $row['product_sell_price'] ?>">
                </div>

                <div class="form-group">
                  <label for="exampleInputWeight">Product Weight</label>
                  <input type="number" name="product_weight" class="form-control" id="exampleInputPrice"
                         value="<?php echo $row['product_weight'] ?>">


                </div>

                <div class="form-group">

                  <div class="form-group">
                    <label for="exampleInputWeightUnit">Product Weight Unit</label>
                    <select class="form-control" name="product_weight_unit_id">
                      <?php echo "<option value='" . $row['product_weight_unit_id'] . "'>" . $weight_unit_name . "</option>"; ?>

                      <?php
                      include('db_connect.php');

                      $result = mysqli_query($con, "SELECT * FROM weight_unit");
                      while ($row3 = mysqli_fetch_array($result)) {
                        echo "<option value='" . $row3['weight_unit_id'] . "'>" . $row3['weight_unit_name'] . "</option>";

                      }
                      echo "</select>";

                      ?>
                  </div>


                  <div class="form-group">

                    <div class="form-group">
                      <label for="exampleInputSupplier">Product Supplier</label>
                      <select class="form-control" name="product_supplier_id">
                        <?php echo "<option value='" . $row['product_supplier_id'] . "'>" . $suppliers_name . "</option>"; ?>


                        <?php
                        include('db_connect.php');

                        $result = mysqli_query($con, "SELECT * FROM suppliers");
                        while ($row4 = mysqli_fetch_array($result)) {
                          echo "<option value='" . $row4['suppliers_id'] . "'>" . $row4['suppliers_name'] . "</option>";

                        }
                        echo "</select>";

                        ?>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputStock">Product Stock</label>
                    <input type="number" name="product_stock" class="form-control" id="exampleInputStock"
                           value="<?php echo $row['product_stock'] ?>">
                  </div>


                  <div class="form-group">
                    <input type="hidden" name="product_image" class="form-control" id="exampleInputPrice"
                           value="<?php echo $row['product_image'] ?>">


                  </div>

                  <div class="form-group ">
                    <label for="exampleInputImage">Product Image</label>


                    <div>
                      <?php echo "  <img src=\"product_images/" . $row['product_image'] . "\" class=\"img-rounded\" width='200' height='200' alt=\"Product Image\">" ?>
                      ;
                    </div>

                    <div class="custom-file">


                      <input type="hidden" class="custom-file-input" id="fileupload" name="MAX_FILE_SIZE"
                             value="2000000"/>

                      <p>Choose a jpg/png file to upload:</p> <input class="btn btn-default" name="uploadedfile"
                                                                     type="file" accept="image/*"/>
                      (Upload 500px x 500px picture)<br/>
                    </div>
                  </div>


                </div>


              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" id="update_product" class="btn btn-primary"><i class="fa fa-check-circle"></i>  Update Product</button>
              </div>
            </form>


          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>


<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jquery-validation -->
<script src="plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="plugins/jquery-validation/additional-methods.min.js"></script>

<script type="text/javascript">

  $(document).on('click', '#update_product', function (e) {


    $('#quickForm').validate({
      rules: {

        product_name: {
          required: true
        },
        product_code: {
          required: true,
        },
        product_category: {
          required: true,
        },
        product_description: {
          required: true,
        },
        
        
        buy_price: {
          required: true,
        },

        product_price: {
          required: true,
        },

        product_weight: {
          required: true,
        },

        product_weight_unit: {
          required: true,
        },

        product_supplier: {
          required: true,
        },

        product_stock: {
          required: true,
        },


      },
      messages: {
        product_name: {
          required: "Please enter product name"
        },
        product_code: {
          required: "Please enter product code"
        },
        product_category: {
          required: "Please enter product category"
        },
        product_description: {
          required: "Please enter product description"
        },

         buy_price: {
          required: "Please enter product buy price"
        },
        product_price: {
          required: "Please enter product sell price"
        },
        product_weight: {
          required: "Please enter product weight"
        },

        product_weight_unit: {
          required: "Please select product weight unit"
        },

        product_supplier: {
          required: "Please select product supplier"
        },
        product_stock: {
          required: "Please enter product stock"
        },

      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      }
    });

  });


</script>


<script type="text/javascript">

  $(document).on('click', '#update_product', function (e) {
    e.preventDefault();
    Swal.fire({
      title: 'Want to update ?',
      text: 'Are you sure?',
      icon: 'warning',
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, Update it!',
      cancelButtonText: 'No'
    }).then((result) => {
      if (result.value) {

        $('#quickForm').submit();

      }
    })

  });
</script>


</body>
</html>
