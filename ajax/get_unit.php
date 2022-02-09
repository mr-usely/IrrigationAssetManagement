<?php
require_once("../../../Initialization/initialize.php");
$itemName = $_POST['ItemName'];
$load = Dynaset::load("SELECT Unit FROM consIrrigItems WHERE ItemNames LIKE '%{$itemName}%'");
$row = mssql_fetch_assoc($load);

if($load){
    echo $row['Unit'];
}
?>