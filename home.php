<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_wishlist'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

   $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_wishlist_numbers->rowCount() > 0){
      $message[] = 'already added to wishlist!';
   }elseif($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to wishlist!';
   }

}

if(isset($_POST['add_to_cart'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if($check_cart_numbers->rowCount() > 0){
      $message[] = 'already added to cart!';
   }else{

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$p_name, $user_id]);

      if($check_wishlist_numbers->rowCount() > 0){
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$p_name, $user_id]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
      $message[] = 'added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/components.css">

</head>
<body>
   
<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>
<?php include 'floating_button.php'; ?>

<div class="mainframe">

   <div class="home-bg">

      <section class="home">
            <!-- Dont delete this section -->
      </section>

   </div>

   <section class="home-category">

      <h1 class="title">shop by category</h1>

      <div class="box-container">

         <div class="box">
            <img src="images/frozen_food.png" alt="" width="40" height="180">
            <h3>Frozen Food</h3>
            <div class="main-category-content"><p>Freshness locked in, flavor never compromised - discover the convenience and quality of our frozen food selection today.</p></div>
            <div class="dropdown">
               <a href="category.php?category=frozen_food" class="btn dropbtn">Frozen Food</a>
               <div class="dropdown-content">
                  <a href="category.php?category=icecream">Ice-cream</a>
                  <a href="category.php?category=seafood">Seafood</a>
                  <a href="category.php?category=meat">Meat</a>
               </div>
            </div>
         </div>

         <div class="box">
            <img src="images/fresh_food.png" alt="" width="40" height="180">
            <h3>Fresh Food</h3>
            <div class="main-category-content"><p>From farm to table, our commitment to freshness means you can taste the difference in every bite.</p></div>
            <div class="dropdown">
            <a href="category.php?category=fresh_food" class="btn">Fresh Food</a>
            <div class="dropdown-content">
                  <a href="category.php?category=fruits">Fruits</a>
                  <a href="category.php?category=vegetables">Vegetables</a>
                  <a href="category.php?category=dairy">Dairy</a>
               </div>
            </div>
         </div>

         <div class="box">
            <img src="images/beverage.png" alt="" width="40" height="180">
            <h3>Beverages</h3>
            <div class="main-category-content"><p>Indulge in pure refreshment with our range of flavorful beverages</p></div>
            <div class="dropdown">
            <a href="category.php?category=beverages" class="btn">Beverages</a>
            <div class="dropdown-content">
                  <a href="category.php?category=softdrink">Soft Drink</a>
                  <a href="category.php?category=bottledwater">Bottled Water</a>
                  <a href="category.php?category=juice">Juice</a>
               </div>
            </div>
         </div>

      </div>

   </section>

   <section class="products">

      <h1 class="title">popular products</h1>

      <div class="box-container">
          

         <?php
            $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 4");
            $select_products->execute();
            if($select_products->rowCount() > 0){
               while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
         ?>
         <form action="" class="box" method="POST">
            <div class="price">&#36<span><?= $fetch_products['price']; ?></span>/-</div>
            <a href="view_page.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
            <img src="product_image/<?= $fetch_products['image']; ?>" alt="" width="20" height="180">
            <div class="name"><?= $fetch_products['name']; ?></div>
            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
            <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
            <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
            <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
            <input type="number" min="1" value="1" name="p_qty" class="qty">
            <input type="submit" value="add to wishlist" class="option-btn" name="add_to_wishlist">
            <input type="submit" value="add to cart" class="btn" name="add_to_cart">
         </form>
         <?php
            }
         }else{
            echo '<p class="empty">no products added yet!</p>';
         }
         ?>
      </div>

   </section>

</div>

<?php include 'footer.php'; ?>  

<script src="js/script.js"></script>

</body>
</html>