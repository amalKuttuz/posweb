<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            max-width: 3.1in;
            margin: 0 auto;
            color: #000;
            background-color: #f9f9f9;
        }

        #invoice-wrap {
            padding: 10px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        #header {
            text-align: center;
            font-size: 12px;
            margin-bottom: 10px;
        }

        #header h1 {
            font-size: 16px;
            margin: 5px 0;
        }

        #header p {
            margin: 2px 0;
        }

        #receipt-title {
            text-align: center;
            margin: 10px 0;
            font-weight: bold;
            font-size: 14px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 5px 0;
        }

        #client-details {
            margin-bottom: 10px;
        }

        #client-details p {
            margin: 2px 0;
            line-height: 1.4;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            text-align: left;
            padding: 5px;
            font-size: 9px;
        }

        th {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
        }

        td {
            border: 1px solid #ddd;
        }

        .summary-table {
            margin-top: 10px;
        }

        .summary-table th,
        .summary-table td {
            border: none;
        }

        .summary-table td {
            text-align: right;
            padding: 3px 0;
        }

        #in-words {
            margin-top: 10px;
            font-style: italic;
            font-size: 9px;
        }

        #footer {
            text-align: center;
            margin-top: 15px;
            font-size: 9px;
            font-weight: bold;
        }

        .button {
            width: 100%;
            margin-top: 10px;
            padding: 5px;
            background-color: #4CAF50;
            color: white;
            font-size: 10px;
            border: none;
            cursor: pointer;
            border-radius: 3px;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>

    <div id="invoice-wrap">
    <?php
        include('db_connect.php');
        include("my_function.php");
        $getid = $_GET['id'];
        $my_result = mysqli_query($con, "SELECT * FROM order_list WHERE invoice_id='$getid'");
        $data = mysqli_fetch_array($my_result)

        ?>
        <?php
        $my_result = mysqli_query($con, "SELECT * FROM shop WHERE shop_id=1");
        $shop_data = mysqli_fetch_array($my_result)

        ?>
        <div id="header">
            <h1><?php echo $shop_data['shop_name'] ?></h1>
            <p><?php echo $shop_data['shop_address'] ?></p>
            <p><?php echo $shop_data['shop_contact'] ?></p>
            <p><?php echo $shop_data['shop_email'] ?></p>
            <p>GSTIN: T34599990908767</p>
        </div>

        <div id="receipt-title">INVOICE</div>

        <div id="client-details">
            <p><b>Customer:</b><?php echo $data['customer_name'] ?> </p>
            <p><?php //echo 'Address: '.$data['address'] ?><br> </p>
            <p><b>Date:</b> <?php echo $data['order_time'].', '.date('d F, Y', strtotime($data['order_date']))?></p>
            <p><b>Served by:</b> <?php echo $data['served_by'] ?></p>
            <p><b>Order Type:</b> <?php echo $data['order_type']?></p>
            <p><b>Payment Method:</b> <?php echo strtoupper( $data['order_payment_method']) ?></p>

        </div>

        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <?php

        $currency = getCurrency();

        $result = mysqli_query($con, "SELECT * FROM order_details WHERE invoice_id='$getid'");

        $i = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr class='item-row'>";
            echo "<td class='item-name'>" . $i . '.  ' . $row['product_name'] . "</td>";
            echo "<td class='cost'>" . getCurrency().' ' . $row['product_price'] . "</td>";
            echo "<td class='cost'>" . $row['product_quantity'] . "</td>";

            echo "<td class='cost'>" . getCurrency().' ' . $row['product_quantity'] * $row['product_price'] . "</td>";


            $i++;
        }

        ?>

          
        </table>

        <table class="summary-table">
            <tr>
                <td><b>Sub Total:</b></td>
                <td><?php echo getCurrency().' '.$data['order_price'] ?></td>
            </tr>
            <tr>
                <td><b>Discount:</b></td>
                <td><?php echo getCurrency().' '.$data['discount'] ?></td>
            </tr>
            <tr>
                <td><b>Total Tax:</b></td>
                <td><?php echo getCurrency().' '.$data['tax'] ?></td>
            </tr>
            <tr>
                <td><b>Total:</b></td>
                <td><b><?php
                    $final_price=$data['order_price']+$data['tax']-$data['discount'] ;
                    echo "<b>".getCurrency().' '; echo $final_price ?></b></td>
            </tr>
        </table>

        <div id="footer">Thank you for Shopping! <br>
        <br><div class="footer"> <img alt='testing' src='plugins/barcode/barcode.php?codetype=Code128&size=50&text=<?php echo $getid ?>&print=true'/> </div>

        </div>



        <div id="invoice-wrap">
        <button class="button" onclick="printInvoice()">Print Invoice</button>
    </div>

    <script>
        function printInvoice() {
            window.print();
            // Redirect to POS page after 5 seconds (adjust as needed)
            setTimeout(function() {
                window.location.href = "neworder.php"; // Replace with your actual POS page URL
            }, 600);
        }
    </script>
    </div>

</body>

</html>
