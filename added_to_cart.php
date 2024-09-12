<?php 
include('database.php');
include('function.php');
include('default.php');

session_start();

$attr = safe_valueto($_POST['attr']);
$cart_type = safe_valueto($_POST['cart_type']);

if($cart_type == 'add'){
  $qty = safe_valueto($_POST['qty']);
  if(isset($_SESSION['USER_ID'])){
    $uid = $_SESSION['USER_ID'];
    manage_cart($uid,$qty,$attr);
  }else{
    $_SESSION['cart'][$attr]['qty']=$qty;
  }
  $get_cart_detail = get_cart_detail();
  $totalPrice = 0;
  foreach($get_cart_detail as $list){
    $totalPrice = $totalPrice+($list['food_qty']*$list['price']);
  }
  $getFoodItemId = getFoodItemId($attr);
  $price=$getFoodItemId['price'];
  $name=$getFoodItemId['food_name'];
  $image=$getFoodItemId['images'];

  $totalFood = count (get_cart_detail());
  $arr = array('totalFoodAdded' => $totalFood, 'totalPrice' => $totalPrice, 'price' => $price, 'food_name' => $name, 'images' => $image);
  echo json_encode($arr);
}

if($cart_type == 'delete'){
  removeFoodFromCart($attr);
  $get_cart_detail = get_cart_detail();
  $totalFood = count ($get_cart_detail);
  $totalPrice = 0;
  foreach($get_cart_detail as $list){
    $totalPrice = $totalPrice+($list['food_qty']*$list['price']);
  }
  $arr = array('totalFoodAdded' => $totalFood, 'totalPrice' => $totalPrice);
  echo json_encode($arr);
}
?>