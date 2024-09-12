<?php 
include('database.php');
include('function.php');
include('default.php');
//include('smtp/PHPMailerAutoload.php');

session_start();


$type = safe_valueto($_POST['type']);
$cid = $_SESSION['USER_ID'];

if ($type == 'profile') {
  $fname = safe_valueto($_POST['fname']);
  $lname = safe_valueto($_POST['lname']);
  $phone = safe_valueto($_POST['phone']);
  $_SESSION['USER_NAME']=$fname;


  $cst_upd_sql = "update customer set fname='$fname', lname='$lname', phone='$phone' where cust_id='$cid'";
  $cst_upd_res = mysqli_query($con,$cst_upd_sql);

  $arr=array('status'=>'success','msg'=>'Profile has been updated');
	echo json_encode($arr);

}

if ($type == 'password') {
  $old_password = safe_valueto($_POST['old_password']);
  $new_password = safe_valueto($_POST['new_password']);

  $verify = mysqli_num_rows(mysqli_query($con, "SELECT * FROM customer WHERE password = '$old_password'"));

  $log_sele_sql = "SELECT password FROM customer WHERE cust_id = '$cid'";
  $log_res = mysqli_query($con, $log_sele_sql);
  $log_row = mysqli_fetch_assoc($log_res);
  $enc_password = $log_row['password'];
  if(password_verify($old_password,$enc_password)){
    if($old_password === $new_password){
      $arr = array('status' => 'error', 'msg' => 'Please enter New Password...!');
    }else{
      $new_password = password_hash($new_password,PASSWORD_BCRYPT);
      $cst_pwd_upd_sql = "update customer set password='$new_password' where cust_id='$cid'";
      $cst_pwd_upd_res = mysqli_query($con,$cst_pwd_upd_sql);
      $arr=array('status'=>'success','msg'=>'Password has been updated!');
    }
  }else{
    $arr = array('status' => 'error', 'msg' => 'Please enter Correct Password... 👀');
  }
  echo json_encode($arr);
}

?>
