<?php
include ("header.php");

if(!isset($_SESSION['USER_ID'])){
	redirect(FRONTEND_SITE_PATH.'main');
}

if(isset($_GET['order_master_id']) && $_GET['order_master_id'] > 0){
  $id = safe_valueto($_GET['order_master_id']);
	$getOrderById = getOrderById($id);
	if($getOrderById[0]['customer_id'] != $_SESSION['USER_ID']){
		redirect(FRONTEND_SITE_PATH.'main');
	}
}else{
	redirect(FRONTEND_SITE_PATH.'main');
}

$cid = $_SESSION['USER_ID'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Order Details</title>
</head>
<body>
	<div class="cart-main-area pt-95 pb-100">
		<div class="container">
			<h3 class="page-title">Order Details</h3>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-12">
					<form method="post">
						<div class="table-content table-responsive">
						<table class="table">
								<thead>
									<tr class="bg-dark head_color">
										<th>#</th>
										<th>Description</th>
										<th class="text-right">Quantity</th>
										<th class="text-right">Unit cost</th>
										<th class="text-right">Total</th>
									</tr>
								</thead>
								
								<tbody>
									<?php 
										$getOrderData = getOrderData($id);
										$i = 1;
										$tp = 0;
										foreach($getOrderData as $list){ 
											$tp = $tp + ($list['price']*$list['qty']);	
										?>
										<tr class="text-right">
											<td class="text-left"><?php echo $i ?></td>
											<td class="text-left"><?php echo $list['food_name']?> (<?php echo $list['food_attribute']?>)</td>
											<td><?php echo $list['qty']?></td>
											<td>$ <?php echo $list['price']?></td>
											<td>$ <?php echo $list['price']*$list['qty']?></td>
										</tr>
									<?php
									$i++; 
									} 
									?>
									<tr>
										<td colspan="3"></td>
										<td><strong>Total</strong></td>
										<td><strong><?php echo $tp ?></strong></td>
									</tr>
								</tbody>
							</table>
						</div>                        
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
<?php
include("footer.php");
?>