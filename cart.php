<?php 
// include('default.php');
include('header.php');
?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
</head>
<body>
  <div class="cart-main-area pt-95 pb-100">
    <div class="container">
      <h3 class="page-title">Your cart items</h3>
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
          <form method="post" class="empty_msg">
            <?php 
              $cartArry = get_cart_detail();
              if(count($cartArry) > 0 ){
            ?>
            <div class="table-content table-responsive">
              
              <table>
                <thead>
                  <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Until Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    foreach($cartArry as $key=>$list){
                  ?>
                    <tr>
                      <td class="product-thumbnail">
                        <a href="#"><img src="<?php echo SITE_FOOD_IMG_CALL.$list['image']?>"></a>
                      </td>
                      <td class="product-name"><a href="#"><?php echo $list['name']?> </a></td>
                      <td class="product-price-cart"><span class="amount">$ <?php echo $list['price']?></span></td>
                      <td class="product-quantity">
                        <div class="cart-plus-minus">
                          <input class="cart-plus-minus-box" type="text" name="qty[<?php echo $key?>][]" value="<?php echo $list['food_qty']?>">
                        </div>
                      </td>
                      <td class="product-subtotal">$ <?php echo $list['food_qty']*$list['price'] ?></td>
                      <td class="product-remove">
                        <a href="javascript:void(0)" onclick="delete_cart('<?php echo $key?>','load')"><i class="fa fa-times"></i></a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            
            <div class="row">
              <div class="col-lg-12">
                <div class="cart-shiping-update-wrapper">
                  <div class="cart-shiping-update">
                    <a href="<?php echo FRONTEND_SITE_PATH?>main">Continue Shopping</a>
                  </div>
                  <div class="cart-clear">
                    <button name="update_cart">Update Shopping Cart</button>
                    <a href="<?php echo FRONTEND_SITE_PATH?>checkout">Checkout</a>
                  </div>
                </div>
              </div>
            </div>
            <?php 
                }else{
                  echo "Your Cart is Empty";
                }
            ?>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>

<?php
include('footer.php');
?>
