<?php
function pr($arr){
  echo '<pre>';
  print_r($arr);
}

function prx($arr){
  echo '<pre>';
  print_r($arr);
  die();
}

function redirect($page){
  ?>
  <script>
    window.location.href='<?php echo $page?>';
  </script>
  <?php
  die();
}

function safe_valueto($val){
  global $con;
  $val = mysqli_real_escape_string($con, $val);
  return $val;
}

function dateFormat($date){
  $dt_str = strtotime($date);
  return date('m-d-Y',$dt_str);
}

function send_email($email,$html,$subject){
	$mail=new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host="smtp.gmail.com";
	$mail->Port=587;
	$mail->SMTPSecure="tls";
	$mail->SMTPAuth=true;
	$mail->Username="aminbrijesh97@gmail.com";
	$mail->Password="bzzg ztzy mria gqqu";
	$mail->setFrom("aminbrijesh97@gmail.com");
	$mail->addAddress($email);
	$mail->IsHTML(true);
	$mail->Subject=$subject;
	$mail->Body=$html;
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if($mail->send()){
		//echo "done";
	}else{
		//echo "Error occur";
	}
}

function random_str(){
  $str = str_shuffle('abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz');
  return $str = substr($str,0,12);
}

function get_cart(){
	global $con;
	$arr = array();
	$id = $_SESSION['USER_ID'];
	$cart_sele_sql = "select * from food_cart where customer_id = '$id'";
	$cart_sele_resu = mysqli_query($con,$cart_sele_sql);

	while($cart_row = mysqli_fetch_assoc($cart_sele_resu)){
		$arr[]=$cart_row;
	}
	return $arr;
}

function manage_cart($uid,$qty,$attr){
	global $con;
	$cart_sel_sql = "select * from food_cart where customer_id = '$uid' and food_item_id = '$attr'";
	$ct_sel_res = mysqli_query($con,$cart_sel_sql);
	if(mysqli_num_rows($ct_sel_res) > 0){
		$cart_row = mysqli_fetch_assoc($ct_sel_res);
		$ct_id = $cart_row['food_cart_id'];
		$cart_update_sql = "update food_cart set food_qty = '$qty' where food_cart_id = '$ct_id'";
		$ct_up_res = mysqli_query($con,$cart_update_sql); 
	}else{
		$cart_insert_sql = "insert into food_cart(food_qty,customer_id,	food_item_id) values('$qty','$uid','$attr')";
		$cart_ins_res = mysqli_query($con,$cart_insert_sql);
	}
}

function getFoodCartStatus(){
	global $con;

	$cartArry = array(); //Calling Data from the Database
	$foodItemArry = array(); 
	if(isset($_SESSION['USER_ID'])){
		$get_cart = get_cart();
		$cartArry = array();
		foreach($get_cart as $list){
			$foodItemArry[] = $list['food_item_id'];
		}
	}else{ // Calling data from the Session [If the User is not Login]
		if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){
			foreach($_SESSION['cart'] as $key => $val){
				$foodItemArry[] = $key;
			}
		}
	}
	// pr($foodItemArry);
	foreach($foodItemArry as $id){
		$cart_sele_sql = "select food_item.food_status as food_item_status,food.food_status,food.food_id from food_item,food where food_item.food_item_id = '$id' and food_item.food_id=food.food_id";
		$cart_sele_resu = mysqli_query($con,$cart_sele_sql);
		$cart_sele_row = mysqli_fetch_assoc($cart_sele_resu);
		//return $cart_sele_row['food_status'];
		if($cart_sele_row['food_status'] == 0){
			$id = $cart_sele_row['food_id'];
			$sel_sql = "select food_item_id from food_item where food_id = '$id'";
			$sel_res = mysqli_query($con,$sel_sql);

			while($sel_row = mysqli_fetch_assoc($sel_res)){
				removeFoodFromCart($sel_row['food_item_id']);
			}
		}

		if($cart_sele_row['food_item_status'] == 0){
			removeFoodFromCart($id);
		}
	}
	// return $cart_sele_row['food_status'];
	// die();
	// prx($cart_sele_row);
}

function get_cart_detail($att_id=''){
	$cartArry = array(); //Calling Data from the Database
	if(isset($_SESSION['USER_ID'])){
		$get_cart = get_cart();
		$cartArry = array();
		foreach($get_cart as $list){
			$cartArry[$list['food_item_id']]['food_qty']=$list['food_qty'];
			$getFoodItemId = getFoodItemId($list['food_item_id']);
			$cartArry[$list['food_item_id']]['price']=$getFoodItemId['price'];
			$cartArry[$list['food_item_id']]['name']=$getFoodItemId['food_name'];
			$cartArry[$list['food_item_id']]['image']=$getFoodItemId['images'];
		}
	}else{ // Calling data from the Session [If the User is not Login]
		if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){
			foreach($_SESSION['cart'] as $key => $val){
				$cartArry[$key]['food_qty']=$val['qty'];
				$getFoodItemId = getFoodItemId($key);
				$cartArry[$key]['price']=$getFoodItemId['price'];
				$cartArry[$key]['name']=$getFoodItemId['food_name'];
				$cartArry[$key]['image']=$getFoodItemId['images'];
			}
		}
	}if($att_id != ''){
		return $cartArry[$att_id]['food_qty'];
	}else{
		return $cartArry;
	}
}

// function get_cart_detail($att_id=''){
// 	$cartArry = array(); //Calling Data from the Database
// 	if(isset($_SESSION['USER_ID'])){
// 		$get_cart = get_cart();
// 		$cartArry = array();
// 		foreach($get_cart as $list){
// 			$getFoodStatus = getFoodStatus($list['food_item_id']);
// 			if($getFoodStatus == 1){
// 				$cartArry[$list['food_item_id']]['food_qty']=$list['food_qty'];
// 				$getFoodItemId = getFoodItemId($list['food_item_id']);

// 				$cartArry[$list['food_item_id']]['price']=$getFoodItemId['price'];
// 				$cartArry[$list['food_item_id']]['name']=$getFoodItemId['food_name'];
// 				$cartArry[$list['food_item_id']]['image']=$getFoodItemId['images'];
// 			}else{
// 				removeFoodFromCart($list['food_item_id']);
// 			}
// 		}
// 	}else{ // Calling data from the Session [If the User is not Login]
// 		if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0){
// 			foreach($_SESSION['cart'] as $key => $val){
// 				$getFoodStatus = getFoodStatus($key);
// 				if($getFoodStatus == 1){
// 					$cartArry[$key]['food_qty']=$val['qty'];
// 					$getFoodItemId = getFoodItemId($key);
// 					$cartArry[$key]['price']=$getFoodItemId['price'];
// 					$cartArry[$key]['name']=$getFoodItemId['food_name'];
// 					$cartArry[$key]['image']=$getFoodItemId['images'];
// 				}else{
// 					removeFoodFromCart($key);
// 				}
// 			}
// 		}
// 	}if($att_id != ''){
// 		return $cartArry[$att_id]['food_qty'];
// 	}else{
// 		return $cartArry;
// 	}
// }

function getFoodItemId($id){
	global $con;
	$prs_sel_sql = "select food.food_name,food.images,food_item.price from food_item,food where food_item.food_item_id='$id' and food.food_id = food_item.food_id";
	$prs_sel_res = mysqli_query($con,$prs_sel_sql);
	$prs_row = mysqli_fetch_assoc($prs_sel_res);
	return $prs_row;
}

function getUserInfo($uid=''){
  global $con;
	$data['fname'] = '';
	$data['lname'] = '';
	$data['email'] = '';
	$data['phone'] = '';

	if(isset($_SESSION['USER_ID'])){
		$uid = $_SESSION['USER_ID'];
	}
	$cst_sel_sql = "select * from customer where cust_id='$uid'";
	$cst_sel_res = mysqli_query($con,$cst_sel_sql);
	$cst_sel_row = mysqli_fetch_assoc($cst_sel_res);
	$data['fname'] = $cst_sel_row['fname'];
	$data['lname'] = $cst_sel_row['lname'];
	$data['email'] = $cst_sel_row['email'];
	$data['phone'] = $cst_sel_row['phone'];
	return $data;
}

function emptyCart(){
	if(isset($_SESSION['USER_ID'])){
		global $con;
		$cst_del_sql = "delete from food_cart where customer_id=".$_SESSION['USER_ID'];
		$cst_del_res = mysqli_query($con,$cst_del_sql);
	}else{
		unset($_SESSION['cart']);
	}
}

function removeFoodFromCart($id){
	if(isset($_SESSION['USER_ID'])){	
		global $con;
		$cart_itm_del_sql = "delete from food_cart where food_item_id='$id' and customer_id=".$_SESSION['USER_ID'];
		$cart_itm_del_res = mysqli_query($con,$cart_itm_del_sql);
	}else{
		unset($_SESSION['cart'][$id]);
	}
}

function getOrderData($oid){
	global $con;
	$ord_sel_sql = "SELECT order_item.price,order_item.qty,food_item.food_attribute,food.food_name from order_item,food_item,food WHERE order_item.order_id=$oid AND order_item.food_item_id=food_item.food_item_id AND food_item.food_id=food.food_id;";
	$ord_sel_res = mysqli_query($con,$ord_sel_sql);
	$data = array();
	while($row = mysqli_fetch_assoc($ord_sel_res)){
		$data[] = $row;
	}
	return $data;
}

function getOrderById($oid){
	global $con;
	$ord_sel_sql = "SELECT * from order_master where order_master_id='$oid'";
	$ord_sel_res = mysqli_query($con,$ord_sel_sql);
	$data = array();
	while($row = mysqli_fetch_assoc($ord_sel_res)){
		$data[] = $row;
	}
	return $data;
}

function orderPlacedEmail($oid,$uid=''){
	$getUserInfo = getUserInfo($uid);
	$fname = $getUserInfo['fname'];
	$email = $getUserInfo['email'];

	$getOrderBy = getOrderById($oid);
	
	$order_id = $getOrderBy[0]['order_master_id'];
	$total_amt = $getOrderBy[0]['total_price']; 

	$getOrderData = getOrderData($oid);

	$html ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html>
		<head>
			<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			<meta name="x-apple-disable-message-reformatting" />
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
			<title></title>
			<style type="text/css" rel="stylesheet" media="all">
			/* Base ------------------------------ */
			
			@import url("https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap");
			body {
				width: 100% !important;
				height: 100%;
				margin: 0;
				-webkit-text-size-adjust: none;
			}
			
			a {
				color: #3869D4;
			}
			
			a img {
				border: none;
			}
			
			td {
				word-break: break-word;
			}
			
			.preheader {
				display: none !important;
				visibility: hidden;
				mso-hide: all;
				font-size: 1px;
				line-height: 1px;
				max-height: 0;
				max-width: 0;
				opacity: 0;
				overflow: hidden;
			}
			/* Type ------------------------------ */
			
			body,
			td,
			th {
				font-family: "Nunito Sans", Helvetica, Arial, sans-serif;
			}
			
			h1 {
				margin-top: 0;
				color: #333333;
				font-size: 22px;
				font-weight: bold;
				text-align: left;
			}
			
			h2 {
				margin-top: 0;
				color: #333333;
				font-size: 16px;
				font-weight: bold;
				text-align: left;
			}
			
			h3 {
				margin-top: 0;
				color: #333333;
				font-size: 14px;
				font-weight: bold;
				text-align: left;
			}
			
			td,
			th {
				font-size: 16px;
			}
			
			p,
			ul,
			ol,
			blockquote {
				margin: .4em 0 1.1875em;
				font-size: 16px;
				line-height: 1.625;
			}
			
			p.sub {
				font-size: 13px;
			}
			/* Utilities ------------------------------ */
			
			.align-right {
				text-align: right;
			}
			
			.align-left {
				text-align: left;
			}
			
			.align-center {
				text-align: center;
			}
			/* Buttons ------------------------------ */
			
			.button {
				background-color: #3869D4;
				border-top: 10px solid #3869D4;
				border-right: 18px solid #3869D4;
				border-bottom: 10px solid #3869D4;
				border-left: 18px solid #3869D4;
				display: inline-block;
				color: #FFF;
				text-decoration: none;
				border-radius: 3px;
				box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
				-webkit-text-size-adjust: none;
				box-sizing: border-box;
			}
			
			.button--green {
				background-color: #22BC66;
				border-top: 10px solid #22BC66;
				border-right: 18px solid #22BC66;
				border-bottom: 10px solid #22BC66;
				border-left: 18px solid #22BC66;
			}
			
			.button--red {
				background-color: #FF6136;
				border-top: 10px solid #FF6136;
				border-right: 18px solid #FF6136;
				border-bottom: 10px solid #FF6136;
				border-left: 18px solid #FF6136;
			}
			
			@media only screen and (max-width: 500px) {
				.button {
					width: 100% !important;
					text-align: center !important;
				}
			}
			/* Attribute list ------------------------------ */
			
			.attributes {
				margin: 0 0 21px;
			}
			
			.attributes_content {
				background-color: #F4F4F7;
				padding: 16px;
			}
			
			.attributes_item {
				padding: 0;
			}
			/* Related Items ------------------------------ */
			
			.related {
				width: 100%;
				margin: 0;
				padding: 25px 0 0 0;
				-premailer-width: 100%;
				-premailer-cellpadding: 0;
				-premailer-cellspacing: 0;
			}
			
			.related_item {
				padding: 10px 0;
				color: #CBCCCF;
				font-size: 15px;
				line-height: 18px;
			}
			
			.related_item-title {
				display: block;
				margin: .5em 0 0;
			}
			
			.related_item-thumb {
				display: block;
				padding-bottom: 10px;
			}
			
			.related_heading {
				border-top: 1px solid #CBCCCF;
				text-align: center;
				padding: 25px 0 10px;
			}
			/* Discount Code ------------------------------ */
			
			.discount {
				width: 100%;
				margin: 0;
				padding: 24px;
				-premailer-width: 100%;
				-premailer-cellpadding: 0;
				-premailer-cellspacing: 0;
				background-color: #F4F4F7;
				border: 2px dashed #CBCCCF;
			}
			
			.discount_heading {
				text-align: center;
			}
			
			.discount_body {
				text-align: center;
				font-size: 15px;
			}
			/* Social Icons ------------------------------ */
			
			.social {
				width: auto;
			}
			
			.social td {
				padding: 0;
				width: auto;
			}
			
			.social_icon {
				height: 20px;
				margin: 0 8px 10px 8px;
				padding: 0;
			}
			/* Data table ------------------------------ */
			
			.purchase {
				width: 100%;
				margin: 0;
				padding: 35px 0;
				-premailer-width: 100%;
				-premailer-cellpadding: 0;
				-premailer-cellspacing: 0;
			}
			
			.purchase_content {
				width: 100%;
				margin: 0;
				padding: 25px 0 0 0;
				-premailer-width: 100%;
				-premailer-cellpadding: 0;
				-premailer-cellspacing: 0;
			}
			
			.purchase_item {
				padding: 10px 0;
				color: #51545E;
				font-size: 15px;
				line-height: 18px;
			}
			
			.purchase_heading {
				padding-bottom: 8px;
				border-bottom: 1px solid #EAEAEC;
			}
			
			.purchase_heading p {
				margin: 0;
				color: #85878E;
				font-size: 12px;
			}
			
			.purchase_footer {
				padding-top: 15px;
				border-top: 1px solid #EAEAEC;
			}
			
			.purchase_total {
				margin: 0;
				text-align: left;
				font-weight: bold;
				color: #333333;
			}
			
			.purchase_total--label {
				padding: 0 15px 0 0;
			}
			
			body {
				background-color: #F4F4F7;
				color: #51545E;
			}
			
			p {
				color: #51545E;
			}
			
			p.sub {
				color: #6B6E76;
			}
			
			.email-wrapper {
				width: 100%;
				margin: 0;
				padding: 0;
				-premailer-width: 100%;
				-premailer-cellpadding: 0;
				-premailer-cellspacing: 0;
				background-color: #F4F4F7;
			}
			
			.email-content {
				width: 100%;
				margin: 0;
				padding: 0;
				-premailer-width: 100%;
				-premailer-cellpadding: 0;
				-premailer-cellspacing: 0;
			}

			.logo-img{
				height: 4rem;
				width: 5rem;
				object-fit: cover;
				mix-blend-mode: darken;
				cursor:default;
			}
			/* Masthead ----------------------- */
			
			.email-masthead {
				padding: 25px 0;
				text-align: center;
			}
			
			.email-masthead_logo {
				width: 94px;
			}
			
			.email-masthead_name {
				font-size: 16px;
				font-weight: bold;
				color: #A8AAAF;
				text-decoration: none;
				text-shadow: 0 1px 0 white;
			}
			/* Body ------------------------------ */
			
			.email-body {
				width: 100%;
				margin: 0;
				padding: 0;
				-premailer-width: 100%;
				-premailer-cellpadding: 0;
				-premailer-cellspacing: 0;
				background-color: #FFFFFF;
			}
			
			.email-body_inner {
				width: 570px;
				margin: 0 auto;
				padding: 0;
				-premailer-width: 570px;
				-premailer-cellpadding: 0;
				-premailer-cellspacing: 0;
				background-color: #FFFFFF;
			}
			
			.email-footer {
				width: 570px;
				margin: 0 auto;
				padding: 0;
				-premailer-width: 570px;
				-premailer-cellpadding: 0;
				-premailer-cellspacing: 0;
				text-align: center;
			}
			
			.email-footer p {
				color: #6B6E76;
			}
			
			.body-action {
				width: 100%;
				margin: 30px auto;
				padding: 0;
				-premailer-width: 100%;
				-premailer-cellpadding: 0;
				-premailer-cellspacing: 0;
				text-align: center;
			}
			
			.body-sub {
				margin-top: 25px;
				padding-top: 25px;
				border-top: 1px solid #EAEAEC;
			}
			
			.content-cell {
				padding: 35px;
			}
			/*Media Queries ------------------------------ */
			
			@media only screen and (max-width: 600px) {
				.email-body_inner,
				.email-footer {
					width: 100% !important;
				}
			}
			
			@media (prefers-color-scheme: dark) {
				body,
				.email-body,
				.email-body_inner,
				.email-content,
				.email-wrapper,
				.email-masthead,
				.email-footer {
					background-color: #333333 !important;
					color: #FFF !important;
				}
				p,
				ul,
				ol,
				blockquote,
				h1,
				h2,
				h3 {
					color: #FFF !important;
				}
				.attributes_content,
				.discount {
					background-color: #222 !important;
				}
				.email-masthead_name {
					text-shadow: none !important;
				}
			}
			</style>
			<!--[if mso]>
			<style type="text/css">
				.f-fallback  {
					font-family: Arial, sans-serif;
				}
			</style>
		<![endif]-->
		</head>
		<body>
		<span class="preheader">This is an invoice for your order from '.FRONTEND_WEBSITE_NAME.'</span>
			<table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
				<tr>
					<td align="center">
						<table class="email-content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
							<tr>
								<td class="email-masthead">
									<a href="javascript:void(0)"><img src="https://i.ibb.co/C12C73h/the-eatery.png" alt="the-eatery" border="0" class="logo-img" /></a>
									</a>
								</td>
							</tr>
							<!-- Email Body -->
							<tr>
								<td class="email-body" width="100%" cellpadding="0" cellspacing="0">
									<table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
										<!-- Body content -->
										<tr>
											<td class="content-cell">
												<div class="f-fallback">
													<h1>Hi '.$fname.',</h1>
													<p>This is an invoice for your recent order placed from <span style="color: crimson; font-weight: 600;">The Eatery</span>.</p>
													<table class="attributes" width="100%" cellpadding="0" cellspacing="0" role="presentation">
														<tr>
															<td class="attributes_content">
																<table width="100%" cellpadding="0" cellspacing="0" role="presentation">
																	<tr>
																		<td class="attributes_item">
																			<span class="f-fallback">
																				<strong>Amount Due:</strong> '.$total_amt.'
																			</span>
																		</td>
																	</tr>
																	<tr>
																		<td class="attributes_item">
																			<span class="f-fallback">
																				<strong>Order ID:</strong> '.$order_id.'
																			</span>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
													<!-- Action -->
													
													<table class="purchase" width="100%" cellpadding="0" cellspacing="0">
													 
														<tr>
															<td colspan="2">
																<table class="purchase_content" width="100%" cellpadding="0" cellspacing="0">
																	<tr>
																		<th class="purchase_heading" align="left">
																			<p class="f-fallback">Description</p>
																		</th>
																		<th class="purchase_heading" align="center">
																			<p class="f-fallback">Quantity</p>
																		</th>
																		<th class="purchase_heading" align="center">
																			<p class="f-fallback">Amount</p>
																		</th>
																	</tr>';
																	
																	$total_price = 0;
																	foreach($getOrderData as $list){
																		$food_price = $list['qty']*$list['price'];
																		$total_price = $total_price + $food_price;
																		$html.= '<tr>
																			<td width="40%" class="purchase_item"><span class="f-fallback">'.$list['food_name'].' ('.$list['food_attribute'].')</span></td>
																			<td width="40%" class="purchase_item"><span class="f-fallback">'.$list['qty'].'</span></td>
																			<td class="align-left" width="20%" class="purchase_item"><span class="f-fallback">$ '.$food_price.'</span></td>
																		</tr>';
																	}
																	
																	$html.='<tr>
																		<td width="40%" class="purchase_footer total_txt" valign="middle" colspan="2">
																			<p class="f-fallback purchase_total purchase_total--label">Total</p>
																		</td>
																		<td width="20%" class="purchase_footer" valign="middle">
																			<p class="f-fallback purchase_total">$ '.$total_price.'</p>
																		</td>
																	</tr>
																</table>
															</td>
														</tr>
													</table>
													<p>If you have any questions about this invoice, simply reply to this email or reach out to our <a href="'.FRONTEND_SITE_PATH.'">support team</a> for help.</p>
													<p>Cheers,
														<br>'.FRONTEND_WEBSITE_NAME.' Team</p>
													<!-- Sub copy -->
													
												</div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</body>
	</html>';
	return $html;
}

function getSales($start, $end){
	global $con;
	$sale_sql = "select sum(total_price) as total_price from order_master where added_on between '$start' and '$end' and order_status=4";
	$sales_res = mysqli_query($con,$sale_sql);
	$arr = array();

	while($row = mysqli_fetch_assoc($sales_res)){
		return number_format($row['total_price'],2);
	}
	return $arr;
}
?>