<?php
require_once("../../../Initialization/initialize.php");

$assignee = $_POST['assignee'];

$sql = Dynaset::load("SELECT TransactionID FROM IrrigDocument WHERE Assignee = '{$assignee}'");
$row = mssql_fetch_assoc($sql);
if($sql){
    echo "Success,".$row['TransactionID'];
}
?>