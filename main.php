<?php 
// include('default.php');
include('header.php');

$mnu_itm = '';
$food_type = '';
$search_str = '';
$mnu_itm_arry = array();

if(isset($_GET['mnu_itm'])){
  $mnu_itm = safe_valueto($_GET['mnu_itm']);
  $mnu_itm_arry = array_filter(explode(' : ',$mnu_itm));
  $mnu_itm_str = implode(',',$mnu_itm_arry);
}

if(isset($_GET['food_type'])){
  $food_type = safe_valueto($_GET['food_type']);
}

if(isset($_GET['search_str'])){
  $search_str = safe_valueto($_GET['search_str']);
}

$fd_ty_arr = array('veg','non-veg','both');
?>

<!doctype html>
<html class="no-js" lang="zxx">
<head>
</head>
<body>
  <div class="breadcrumb-area gray-bg">
    <div class="container">
      <div class="breadcrumb-content">
        <ul>
          <li><a href="<?php echo FRONTEND_SITE_PATH?>index">Home</a></li>
          <!-- <li class="active">Shop Grid Style </li> -->
        </ul>
      </div>
    </div>
  </div>
    
  <div class="shop-page-area pt-100 pb-100">
    <div class="container">
      <div class="row flex-row-reverse">
        <div class="col-lg-9">
        <div class="shop-topbar-wrapper">
          <div class="product-sorting-wrapper">
            <div class="product-show shorting-style search_box_main">
              <?php
                foreach($fd_ty_arr as $list){ 
                  $radio_selected = '';
                  if($list == $food_type){
                    $radio_selected = "checked='checked'";
                  }
                ?>
                <?php echo strtoupper($list)?> <input type="radio" class="radioBtn" <?php echo $radio_selected?> name="food_type" value="<?php echo $list?>" onclick="setFoodType('<?php echo $list?>')"/>
              <?php
              }
              ?>
            </div>

            <div class="product-show shorting-style search_box_main_2">
              <input type="textbox" id="search" class="search_box_txt" value="<?php echo $search_str?>"/>
              <input type="button" class="submit btn-style search_box_btn" value="Search" onclick="setSearch()"/>
            </div>
          </div>
        </div>
        <?php
          $menu_id = 0;
          $food_sele_sql = "select * from food where food_status = 1";
          if($mnu_itm!= ''){
            $food_sele_sql.=" and menu_id in ($mnu_itm_str)";
          }

          if($food_type!= '' && $food_type!= 'both'){
            $food_sele_sql.=" and food_type = '$food_type'";
          }

          if($search_str!= ''){
            $food_sele_sql.=" and (food_name like '%$search_str%' or description like '%$search_str%')";
          }

          
          $food_sele_sql.=" order by food_name desc";
          $fd_res = mysqli_query($con,$food_sele_sql);
          $fd_count = mysqli_num_rows($fd_res);
        ?>             
          <div class="grid-list-product-wrapper">
            <div class="product-grid product-view pb-20">
              <?php if($fd_count>0){?>
                <div class="row">
                <?php
                    while ($fd_row = mysqli_fetch_assoc($fd_res)) {
                  ?>
                  <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                    <div class="product-wrapper">
                      <div class="product-img">
                        <a href="#">
                          <img src="<?php echo SITE_FOOD_IMG_CALL.$fd_row['images']?>" alt="">
                        </a>
                      </div>
                      
                      <div class="product-content" id="food_attri">
                        <h4>
                          <?php 
                            if($fd_row['food_type'] == 'veg'){
                              echo "<img class='food_ty_icon' src='front_assets/img/icon-img/veg.png'/>";
                            }else{
                              echo "<img class='food_ty_icon' src='front_assets/img/icon-img/non_veg.png'/>";
                            }
                          ?>
                          <a id="fd_nme" href="javascript:void(0)"><?php echo $fd_row['food_name']?></a>
                        </h4>
                        <?php
                          $fd_att_sel_sql= 'select * from food_item where food_status = "1" and food_id="'.$fd_row['food_id'].'" order by price asc';
                          $fd_att_sel_res = mysqli_query($con,$fd_att_sel_sql);
                        ?>
                        <div class="product-price-wrapper">
                          <?php 
                            while ($fd_att_row = mysqli_fetch_assoc($fd_att_sel_res)) {
                              echo "<div class='att_prs'> <input type='radio' class='radioBtn' name='radio".$fd_row['food_id']."' id='radio".$fd_row['food_id']."' value='".$fd_att_row['food_item_id']."'/>";
                              echo '<span class="attr">'.$fd_att_row["food_attribute"].'</span>';
                              echo '<span class="prs">($'.$fd_att_row["price"].')</span>';

                              $added_msg="";
                              if(array_key_exists($fd_att_row["food_item_id"],$cartArry)){
                                $added_qty = get_cart_detail($fd_att_row["food_item_id"]);
                                $added_msg ="(Added - $added_qty)";
                              }
                              echo " <span class='cart_added_txt' id='cart_qty_add_msg_".$fd_att_row["food_item_id"]."'>".$added_msg."</span>";
                              echo "</div>";
                            }
                          ?>
                        </div>
                        <div class="pro_qty_wrapper">
                          <select class="qty_dropdown" id="qty<?php echo $fd_row['food_id']?>">
                            <option value="0">Qty</option>
                            <?php 
                              for($i = 1; $i <= 10; $i++){
                                echo "<option>$i</option>";
                              }
                            ?>
                          </select>
                          <i class='bx bxs-cart-add add_car_icon' onclick="add_to_cart('<?php echo $fd_row['food_id']?>','add')"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php 
                    }
                  ?>
                </div>
              <?php
                } else {
                  echo 'No Food Item Found...!';
                }
              ?>
            </div>
          </div>
        </div>
        <?php
          $menu_sel_sql = "select * from menu where menu_status = 1 order by menu_stack desc";
          $mnu_res = mysqli_query($con, $menu_sel_sql);
        ?>
        <div class="col-lg-3">
          <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
            <div class="shop-widget">
              <h4 class="shop-sidebar-title">View By Menu</h4>
              <div class="shop-catigory">
                <ul id="faq" class="menu_list">
                <li><a href="<?php echo FRONTEND_SITE_PATH?>main">Clear</a></li>
                <?php
                  while ($mnu_row = mysqli_fetch_assoc($mnu_res)){
                    $cls = "selected"; 
                    if($menu_id == $mnu_row['menu_id']){
                      $cls = 'active';
                    }
                    $selected = '';
                    if(in_array($mnu_row['menu_id'],$mnu_itm_arry)){
                      $selected = "checked='checked'";
                    }

                    echo "<li> <input type='checkbox' $selected onclick=click_chkbox('".$mnu_row['menu_id']."') class='mnu_chkbox' name='mnu_arry[]' value='".$mnu_row['menu_id']."'> ".$mnu_row['menu_name']."</li>";  
                  }
                ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <form method="get" id="menuItm">
    <input type="hidden" name="mnu_itm" id="mnu_itm" value="<?php echo $mnu_itm ?>">
    <input type="hidden" name="food_type" id="food_type" value="<?php echo $food_type ?>">
    <input type="hidden" name="search_str" id="search_str" value='<?php echo $search_str ?>'>
  </form>
</body>
</html>

<?php 
include ("footer.php");
?>