<!DOCTYPE html>

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>

    <title>Order Invoice</title>

    <link rel='stylesheet' type='text/css' href='css/style.css'/>
    <link rel='stylesheet' type='text/css' href='css/print.css' media="print"/>
    <script type='text/javascript' src='js/jquery-1.3.2.min.js'></script>
    <script type='text/javascript' src='js/example.js'></script>
    
      <style type="text/css">
        @media print {
            #printbtn {
                display :  none;
            }
        }


        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }


    </style>

    <script>
        function printpage()
        {
            window.print()
        }
    </script>
    
    

</head>

<body>

<div id="page-wrap">

    <textarea id="header">INVOICE</textarea>

    <div id="identity">

        <?php
        include('db_connect.php');
        include("my_function.php");
        $getid = $_GET['id'];
        $my_result = mysqli_query($con, "SELECT * FROM order_list WHERE invoice_id='$getid'");
        $data = mysqli_fetch_array($my_result)

        ?>


        <p id="address">
            CUSTOMER NAME<br>
            <?php echo $data['customer_name'] ?><br>
<!--            --><?php //echo 'Phone: '. $data['phone'] ?><!--<br>-->
<!--            --><?php //echo $data['additional_phone'] ?><!--<br>-->
<!--            --><?php //echo 'Address: '.$data['address'] ?><!--<br>-->



        </p>

        <div id="logo">


            <?php


            $my_result = mysqli_query($con, "SELECT * FROM shop WHERE shop_id=1");
            $shop_data = mysqli_fetch_array($my_result)

            ?>

            <!--Company Details here-->
           <h2><?php echo $shop_data['shop_name'] ?></h2>
            <p>Address: <?php echo $shop_data['shop_address'] ?></p>
            <p>Contact: <?php echo $shop_data['shop_contact'] ?></p>
            <p>Email:  <?php echo $shop_data['shop_email'] ?></p>

        </div>

    </div>

    <div style="clear:both"></div>

    <div id="customer">



        <table id="meta2">

            <tr>

                <td class="meta-head">Order Type</td>
                <td><p id="date"><?php echo $data['order_type']?> </p></td>
            </tr>
            <tr>
                <td class="meta-head">Barcode</td>

                <td>
                    <div class="due"> <img alt='testing' src='plugins/barcode/barcode.php?codetype=Code128&size=50&text=<?php echo $getid ?>&print=true'/> </div>
                </td>






        </table>

        <table id="meta">
            <tr>
                <td class="meta-head">Invoice #</td>
                <td><p><?php echo  $_GET['id'] ?></p></td>
            </tr>
            <tr>

                <td class="meta-head">Time & Date</td>
                <td><p id="date"><?php echo $data['order_time'].', '.date('d F, Y', strtotime($data['order_date']))?></p></td>
            </tr>
            <tr>
                <td class="meta-head">Served By</td>
                <td>
                    <div class="due"><?php echo $data['served_by'] ?></div>
                </td>
            </tr>

            <tr>
                <td class="meta-head">Payment Method</td>
                <td>
                    <div class="due"><?php echo strtoupper( $data['order_payment_method']) ?></div>
                </td>
            </tr>


        </table>

    </div>

    <table id="items">

        <tr>
            <th>Item</th>
            <th>Description</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>


        <?php

        $currency = getCurrency();

        $result = mysqli_query($con, "SELECT * FROM order_details WHERE invoice_id='$getid'");

        $i = 1;
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr class='item-row'>";
            echo "<td class='item-name'>" . $i . '.  ' . $row['product_name'] . "</td>";
            echo "<td class='description'>" . $row['product_name'] . "- Weight:".$row['product_weight']."</td>";
            echo "<td class='cost'>" . getCurrency().' ' . $row['product_price'] . "</td>";
            echo "<td class='cost'>" . $row['product_quantity'] . "</td>";

            echo "<td class='cost'>" . getCurrency().' ' . $row['product_quantity'] * $row['product_price'] . "</td>";


            $i++;
        }

        ?>


        <tr>
            <td colspan="2" class="blank"></td>
            <td colspan="2" class="total-line">Subtotal</td>
            <td class="total-value">
                <div id="subtotal"> <?php echo getCurrency().' '.$data['order_price'] ?></div>
            </td>
        </tr>



        <tr>
            <td colspan="2" class="blank"></td>
            <td colspan="2" class="total-line">Tax (+)</td>
            <td class="total-value">
                <div id="subtotal"><?php echo getCurrency().' '.$data['tax'] ?></div>
            </td>
        </tr>

        <tr>
            <td colspan="2" class="blank"></td>
            <td colspan="2" class="total-line">Discount (-)</td>
            <td class="total-value">
                <div id="subtotal"><?php echo getCurrency().' '.$data['discount'] ?></div>
            </td>
        </tr>


        <tr>
            <td colspan="2" class="blank"></td>
            <td colspan="2" class="total-line balance">Total Amount =</td>
            <td class="total-value balance">
                <div class="due"><?php
                    $final_price=$data['order_price']+$data['tax']-$data['discount'] ;
                    echo "<b>".getCurrency().' '; echo $final_price ?></b></div>
            </td>
        </tr>

    </table>

    <div id="terms">
        <h5>THANK YOU</h5>
<!--        <p>--><?php //echo strtoupper(getAmountInWord($final_price)) . ' ONLY' ?><!--</p>-->
    </div>
    
    
     <div align='center'>
        <input class="button" id ="printbtn" type="button" value="Print Invoice" onclick="window.print();" >
    </div>

    <br>
    <br>
    <br>

</div>

</body>

</html>