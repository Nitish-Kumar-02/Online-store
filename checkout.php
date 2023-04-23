<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';


@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['order'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. '. $_POST['flat'] .' '. $_POST['city'] .' '. $_POST['state'] .' '. $_POST['country'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $placed_on = date('d-M-Y');

   $cart_total = 0;
   $cart_products[] = '';

   $cart_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $cart_query->execute([$user_id]);
   if($cart_query->rowCount() > 0){
      while($cart_item = $cart_query->fetch(PDO::FETCH_ASSOC)){
         $cart_products[] = $cart_item['name'].' ( '.$cart_item['quantity'].' )';
         $sub_total = ($cart_item['price'] * $cart_item['quantity']);
         $cart_total += $sub_total;
      };
   };

   $total_products = implode(', ', $cart_products);

   $order_query = $conn->prepare("SELECT * FROM `orders` WHERE name = ? AND number = ? AND email = ? AND method = ? AND address = ? AND total_products = ? AND total_price = ?");
   $order_query->execute([$name, $number, $email, $method, $address, $total_products, $cart_total]);

   if($cart_total == 0){
      $message[] = 'your cart is empty';
   }elseif($order_query->rowCount() > 0){
      $message[] = 'order placed already!';
   }else{
      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES(?,?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $cart_total, $placed_on]);

   $mail = new PHPMailer(true);
   $user_type='admin';
   $select_admin = $conn->prepare("SELECT * FROM `users` WHERE user_type = ? order by id desc limit 1");
   $select_admin->execute([$user_type]);
   if($select_admin->rowCount() > 0){
      $fetch_admin = $select_admin->fetch(PDO::FETCH_ASSOC);?>

<?php
      
   ?>
  <?php try {
      
      $mail->isSMTP();
      $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
      $mail->Username   = $fetch_admin['email'];                     //SMTP username
      $mail->Password   = $fetch_admin['authpass'];                               //SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
      $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

      $mail->setFrom('from@gmail.com', $fetch_admin['name']);
      $mail->addAddress($_POST['email'], $_POST['name']);     //Add a recipient

      $mail->isHTML(true);                                  //Set email format to HTML
      $mail->Subject = 'MyGroc. | Proof of Purchase';
      $string2=array();
      $string1 = 'Hello,'.$_POST['name'].'. Thank You for shopping from MyGroc.Your purchase order of <b>'.date("d-m-y").' is as follows -
      <br><br>
               <table border="2"  style="width:100%">
                  <tr>
                     <th>Item</th>
                     <th>Quantity</th>
                     <th>Total</th>
                  </tr>';
                  $cart_grand_total = 0;
                     $select_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                     $select_cart_items->execute([$user_id]);
                     if($select_cart_items->rowCount() > 0){
                        while($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)){
                           $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
                           $cart_grand_total += $cart_total_price;
                 $string = 
                 '<tr>
                    <td>'.$fetch_cart_items['name'].'</td>
                    <td>'.$fetch_cart_items['quantity'].'</td>
                    <td>'.$sub_total = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']).'</td>
                  </tr>';
                  array_push($string2, $string);
                  }
                    } 
   $string3 = '</table>
            <p><strong>Grand Total: </strong>  <span>$'.$cart_grand_total.'/-</span></p>
            ';
$mail->Body = $string1.implode("\n", $string2).$string3;
      $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

      $mail->send();?>
      <script>alert("Order placed successfully. Please check you Email (Don't forget to check spam too!)"); </script>
  <?php } catch (Exception $e) {?>
     <?php print_r($mail->send()); ?>
  <?php }
   }
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$user_id]);

   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="display-orders">

   <?php
      $cart_grand_total = 0;
      $select_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart_items->execute([$user_id]);
      if($select_cart_items->rowCount() > 0){
         while($fetch_cart_items = $select_cart_items->fetch(PDO::FETCH_ASSOC)){
            $cart_total_price = ($fetch_cart_items['price'] * $fetch_cart_items['quantity']);
            $cart_grand_total += $cart_total_price;
   ?>
   <p> <?= $fetch_cart_items['name']; ?> <span>(<?= '$'.$fetch_cart_items['price'].'/- x '. $fetch_cart_items['quantity']; ?>)</span> </p>
   <?php
    }
   }else{
      echo '<p class="empty">your cart is empty!</p>';
   }
   ?>
   <div class="grand-total">grand total : <span>$ 
      <?= $cart_grand_total; ?>/-</span></div>
</section>

<section class="checkout-orders">

   <form action="" method="POST">

      <h3>place your order</h3>

      <div class="flex">
         <div class="inputBox">
            <span>Enter Your Name :</span>
            <input type="text" name="name" placeholder="enter your name" class="box" required>
         </div>
         <div class="inputBox">
            <span>Enter Your Phone Number :</span>
            <input type="text" name="number" placeholder="enter your number" class="box" required>
         </div>
         <div class="inputBox">
            <span>Enter Your Address</span>
            <input type="text" name="flat" placeholder="e.g. House no. and street name" class="box" required>
         </div>
         <div class="inputBox">
            <span>Enter City Name</span>
            <input type="text" name="city" placeholder="e.g.Melbourne" class="box" required>
         </div>
         <div class="inputBox">
            <span>Enter State Name</span>
            <input type="text" name="state" placeholder="e.g. New South Wales" class="box" required>
         </div>
         <div class="inputBox">
            <span>Enter Country Name</span>
            <input type="text" name="country" placeholder="e.g. Australia" class="box" required>
         </div>
         <div class="inputBox">
            <span>Enter Your Email</span>
            <input type="email" name="email" placeholder="enter your email" class="box" required>
         </div>
         <div class="inputBox">
            <span>payment method :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">cash on delivery</option>
               <option value="credit card">credit card</option>
               <option value="paytm">paytm</option>
               <option value="paypal">paypal</option>
            </select>
         </div>

      </div>

      <input type="submit" name="order" class="btn <?= ($cart_grand_total > 1)?'':'disabled'; ?>" value="place order">

   </form>

</section>


<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>