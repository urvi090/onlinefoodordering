<?php 
include('database.php');
include('function.php');
include('default.php');
include('vendor/autoload.php'); //HTML convert to PDF

session_start();

if(isset($_SESSION['admin_nm'])){

}else{
  if(!isset($_SESSION['USER_ID'])){
    redirect(FRONTEND_SITE_PATH.'main');
  }
}

if(isset($_GET['order_master_id']) && $_GET['order_master_id'] > 0){
  $id = safe_valueto($_GET['order_master_id']);
  
  $sel_sql = "select * from order_master where order_master_id='$id'";
  $sel_res = mysqli_query($con,$sel_sql);
  if(isset($_SESSION['admin_nm'])){
    $row = mysqli_fetch_array($sel_res);
    $uid = $row['customer_id'];
  }else{
    $sel_row = mysqli_fetch_assoc($sel_res);
    
    if($sel_row['customer_id'] != $_SESSION['USER_ID']){
      redirect(FRONTEND_SITE_PATH.'main');
    }
    $uid = $_SESSION['USER_ID'];
  }
  

  $emailHTML = orderPlacedEmail($id,$uid);

  $mpdf = new \Mpdf\Mpdf();
  $mpdf -> WriteHTML($emailHTML);
  $file = time().'.pdf';
  $mpdf -> Output($file,'D');
}
?>