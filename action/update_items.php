<?php
require_once("../../../Initialization/initialize.php");
$found_user = Personnel::find_by_userid($session->UserID); 

$id                 = $_POST['ID'];
$transactID         = $_POST['TransactionID'];
$itemName           = $_POST['ItemNames'];
$unitMeasurement    = $_POST['UnitMeasurement'];
$itemStatus         = $_POST['ItemStatus'];
$quantity           = $_POST['Quantity'];
$remarks            = $_POST['Remarks'];
$ip                 = $_SERVER['REMOTE_ADDR'];
$encoder            = $found_user->FirstName.' '.$found_user->LastName;;

$category = mssql_fetch_assoc(Dynaset::load("Select TransactionID, Category, DocumentNo From IrrigDocument Where PK = {$$id}"));

$sql = "UPDATE IrrigItemNames SET ItemName = '{$itemName}', UnitMeasurement = '{$unitMeasurement}', ItemStatus = '{$itemStatus}', Quantity = {$quantity}, Remarks = '{$remarks}' WHERE ID = {$id}";

$logs = "INSERT INTO IrrigAssetManagementLog (TransactionID, Category, Action, IPAddress, DateCreated, Encoder)
VALUES ('{$category['TransactionID']}','{$category['Category']}', 'Updated the Items in Document No: {$category['Category']}, Received By: {$encoder}', '{$ip}', GETDATE(), '{$encoder}')";

$data = Dynaset::execute($sql);

if($data){
    $exe_log = Dynaset::execute($logs);
    echo "Update Success!";
}
?>