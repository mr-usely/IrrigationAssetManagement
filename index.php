<?php 
require_once("../../Initialization/initialize.php");
if (!$session->is_logged_in()) {redirect_to("../index.php"); };
$found_user = Personnel::find_by_userid($session->UserID); 
?>

<!-- Header --->
<?php include_once 'base/header.php'; ?>

<!-- Navbar --->
<?php include_once 'base/navbar.php'; ?>
        
<!-- Sidebar --->
<?php include_once 'base/sidebar.php'; ?>

<?php

  switch(true){
    case ($menu == "dashboard"):
    case null:
      include_once 'reso/dashboard.php';
      break;
    case ($menu == "liquidation"):
      include_once 'reso/liquidation.php';
      break;
    case ($menu == "warehouse_inventory"):
      include_once 'reso/warehouse_inventory.php';
      break;
    case ($menu == "detailed_inventory"):
      include_once 'reso/detailed_inventory.php';
      break;
    default:
      echo "Page Not Found";
      break;
  }

?>

<!-- Encoding Form -->
<?php include_once 'reso/asset_form.php'; ?>
 
<!-- Footer --->
<?php include_once 'base/footer.php'; ?>