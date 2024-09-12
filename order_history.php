<?php
include ("header.php");

if(!isset($_SESSION['USER_ID'])){
	redirect(FRONTEND_SITE_PATH.'main');
}

$cid = $_SESSION['USER_ID'];

if(isset($_GET['cancel_id'])){
	$cancel_id = safe_valueto($_GET['cancel_id']);

	$cancel_at = date('Y-m-d h:i:s');
	mysqli_query($con,"update order_master set order_status = '5',cancel_by='customer',cancel_at='$cancel_at' where order_master_id='$cancel_id' and order_status='1' and customer_id='$cid'");
}

$all_data_sql = "select order_master.*,order_status.order_status as order_status_str from order_master,order_status where order_master.order_status=order_status.order_status_id and order_master.customer_id='$cid' order by order_master.order_master_id desc";
$res = mysqli_query($con, $all_data_sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Order History</title>
</head>
<body>
	<div class="cart-main-area pt-95 pb-100">
		<div class="container">
			<h3 class="page-title">Order History</h3>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-12">
					<form method="post">
						<div class="table-content table-responsive">
							<table>
								<thead>
									<tr>
										<th>Order ID</th>
										<th>First Name</th>
										<th>Price</th>
										<th>Address</th>
										<th>Zipcode</th>
										<th>Order Status</th>
										<th>Payment Status</th>
									</tr>
								</thead>
								<tbody>
									<?php if(mysqli_num_rows($res) > 0){ 
										$i = 1;
										while ($row = mysqli_fetch_assoc($res)) {
									?>
										<tr>
											<td>
												<div class="order_dtl_link_id">
													<a title="View Order Details" href="<?php echo FRONTEND_SITE_PATH.'order_details?order_master_id='.$row['order_master_id'] ?>"><?php echo $row['order_master_id'] ?></a>
												</div> <br>
												<a href="<?php echo FRONTEND_SITE_PATH?>download_invoice?order_master_id=<?php echo $row['order_master_id'] ?>"> <i class='bx bxs-file-pdf pdf_dwn_icon' title="Download Invoice"></i> </a>
											</td>
											<td><?php echo $row['first_name'] ?></td>
											<td>$ <?php echo $row['total_price'] ?></td>
											<td>
												<?php echo $row['address'] ?>
											</td>
											<td>
												<?php echo $row['zip_code'] ?>
											</td>	
											<td>
												<?php
													echo $row['order_status_str'];

													if($row['order_status'] == 1){
														echo '<br>';
														echo "<a class='cancel_btn' href='?cancel_id=".$row['order_master_id']."'>Cancel</a>";
													}
												?>
											</td>
											<td>
												<div class="payment_status payment_status_<?php echo $row['payment_status']?>"><?php echo ucfirst($row['payment_status']) ?></div>
											</td>
										</tr>
									<?php
										}}
									?>
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