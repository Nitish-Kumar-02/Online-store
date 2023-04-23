<div class="floating_action" onclick="floating_action_toggle();">
    <span><img src="product_image/cart.png" alt="" width="70" height="70"></span>
    <ul>
        <li>
            <table>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
                <?php
                    $grand_total = 0;
                    $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                    $select_cart->execute([$user_id]);
                    if($select_cart->rowCount() > 0){
                    while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){ 

                    ?>
                <tr>
                    <td><?= $fetch_cart['name']; ?></td>
                    <td><?= $fetch_cart['quantity']; ?></td>
                    <td>Rs.<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></td>
                </tr>
                <?php }
                    } ?>
            </table>
        </li>
    </ul>
</div>

<script type="text/javascript">
    function floating_action_toggle(){
   var action = document.querySelector('.floating_action');
   action.classList.toggle('active')
}
</script>
