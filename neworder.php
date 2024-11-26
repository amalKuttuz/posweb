<?php
session_start();
if (!isset($_SESSION['email']) || !isset($_SESSION['user_type']) || !isset($_SESSION['key'])) {
    header("location:index.php");
    exit();
}

include('db_connect.php');

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Prevent adding the same item multiple times on refresh
if (!isset($_SESSION['last_added_product'])) {
    $_SESSION['last_added_product'] = null;
}

// Handle adding products to the cart
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = intval($_POST['quantity']);

    if ($_SESSION['last_added_product'] !== $product_id) {
        // Use prepared statements for security
        $stmt = $con->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->bind_param("s", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $item = [
                'id' => $row['product_id'],
                'name' => $row['product_name'],
                'price' => $row['product_sell_price'],
                'quantity' => $quantity,
                'total' => $row['product_sell_price'] * $quantity
            ];

            // Check if the item already exists in the cart
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
                $_SESSION['cart'][$product_id]['total'] = $_SESSION['cart'][$product_id]['quantity'] * $_SESSION['cart'][$product_id]['price'];
            } else {
                $_SESSION['cart'][$product_id] = $item;
            }

            $_SESSION['last_added_product'] = $product_id;
        } else {
            echo "<script>Swal.fire('Error!', 'Product not found.', 'error');</script>";
        }

        $stmt->close();
    }
}

// Handle removing items from the cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
}

// Calculate total price
$total_price = 0;
foreach ($_SESSION['cart'] as $cart_item) {
    $total_price += $cart_item['total'];
}

// Handle order submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['place_order'])) {
    $invoice_id = uniqid();
    $order_date = date('Y-m-d');
    $order_time = date('H:i:s');
    $order_type = $_POST['order_type'];
    $payment_method = $_POST['payment_method'];
    $customer_name = $_POST['customer_name'];
    $discount = isset($_POST['discount']) ? floatval($_POST['discount']) : 0;
    $tax = isset($_POST['tax']) ? floatval($_POST['tax']) : 0;

    // Apply discount and tax
    $final_price = $total_price - $discount + $tax;

    $stmt = $con->prepare("INSERT INTO order_list (invoice_id, order_date, order_time, order_type, order_payment_method, order_price, discount, tax, customer_name, served_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssdidss", $invoice_id, $order_date, $order_time, $order_type, $payment_method, $final_price, $discount, $tax, $customer_name, $_SESSION['email']);
    $stmt->execute();

    foreach ($_SESSION['cart'] as $item) {
        $stmt = $con->prepare("INSERT INTO order_details (invoice_id, product_name, product_quantity, product_weight, product_price, product_order_date, product_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $weight = 'N/A'; // Assuming weight is not provided
        $stmt->bind_param("ssisdss", $invoice_id, $item['name'], $item['quantity'], $weight, $item['price'], $order_date, $item['id']);
        $stmt->execute();
    }

    unset($_SESSION['cart']); // Clear cart
      // Redirect to invoice page after successful order
    if ($stmt->execute()) { // Check if order insertion was successful
        $invoice_url = "invoice.php?id=" . $invoice_id;
        header("Location: $invoice_url");
        exit;
    } else {
        echo "<script>Swal.fire('Error!', 'Order placement failed.', 'error');</script>";
  }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>POS CART</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="plugins/jquery.min/jquery.min.js"></script>
    <!--Preloader-->
    <link rel="stylesheet" href="dist/css/preloader.css">
    <script src="dist/js/preloader.js"></script>


    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!--For data export and print button css-->
    <link rel="stylesheet" href="dist/css/buttons.dataTables.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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


            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
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
                        <a href="products.php" class="nav-link">
                            <i class="nav-icon fas fa-shopping-bag"></i>
                            <p>
                                Products

                            </p>
                        </a>
                    </li>


                    <li class="nav-item">
                        <a href="orders.php" class="nav-link active">
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
                    <div class="col-sm-6">

                    </div> 

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
                    <h3 class="card-title">POS Cart</h3>
                    </div>
                        <!-- /.card-header -->
                        <div class="card-body">
    <!-- Product Search -->
    <form method="post" action="" class="p-3">
        <div class="form-group">
            <label for="product_id">Search Product:</label>
            <select class="form-control" name="product_id" id="product_id" required>
                <?php
                $result = mysqli_query($con, "SELECT * FROM products");
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . htmlspecialchars($row['product_id']) . "'>" . htmlspecialchars($row['product_name']) . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" class="form-control" id="quantity" value="1" placeholder="Enter quantity" required min="1">
        </div>
        <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
    </form>

    <!-- Cart Display -->
    <h3>Items in Cart</h3>
    <?php if (!empty($_SESSION['cart'])): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price (₹)</th>
                    <th>Total (₹)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($item['price']); ?></td>
                        <td><?php echo htmlspecialchars($item['total']); ?></td>
                        <td><a href="?remove=<?php echo htmlspecialchars($item['id']); ?>" class="btn btn-danger btn-sm">Remove</a></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total Price:</strong></td>
                    <td><strong><?php echo htmlspecialchars($total_price); ?></strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <br>

        <!-- Order Details Form -->
        <form method="post" action="">
        <button type="submit" name="place_order" class="btn btn-success">Place Order</button>

            <div class="form-group">         <br>

                <label for="customer_name">Customer Name:</label>
                <input type="text" name="customer_name" value="Walkin" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="order_type">Order Type:</label>
                <select name="order_type" value="PickUp" class="form-control" required>
                    <option value="PickUp">PickUp</option>
                    <option value="Delivery">Delivery</option>
                </select>
            </div>
            <div class="form-group">
                <label for="payment_method">Payment Method:</label>
                <select name="payment_method" value="Cash" class="form-control" required>
                    <option value="Cash">Cash</option>
                    <option value="Credit Card">Card</option>
                </select>
            </div>
            <div class="form-group">
                <label for="discount">Discount:</label>
                <input type="number" value="0" name="discount" class="form-control">
            </div>
            <div class="form-group">
                <label for="tax">Tax:</label>
                <input type="number" value="0" name="tax" class="form-control">
            </div>
            <!-- <button type="submit" name="place_order" class="btn btn-success">Place Order</button> -->
        </form>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
</div>
                        <!-- /.card-body -->
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
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
