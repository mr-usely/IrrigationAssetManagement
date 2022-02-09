<?php
require_once("../../../Initialization/initialize.php");
$found_user = Personnel::find_by_userid($session->UserID); 

$id                 = $_POST['ID'];
$category           = $_POST['Category'];
$itemName           = $_POST['ItemName'];
$unitMeasurement    = $_POST['UnitMeasurement'];
$itemStatus         = $_POST['ItemStatus'];
$quantity           = $_POST['Quantity'];
$remarks            = $_POST['Remarks'];
$documentNo         = $_POST['DocumentNo'];
$ip                 = $_SERVER['REMOTE_ADDR'];
$encoder            = $found_user->FirstName.' '.$found_user->LastName;
$transactionID      = $_POST['TransactionID'];

$x = Dynaset::load("Select TransactionID, Category From IrrigDocument Where DocumentNo = '{$documentNo}'");
$categ = mssql_fetch_assoc($x);

$add_item = "INSERT INTO IrrigItemNames (ID, Category, ItemName, UnitMeasurement, ItemStatus, Quantity, Remarks) VALUES
({$id}, '{$category}', '{$itemName}', '{$unitMeasurement}', '{$itemStatus}', {$quantity}, '{$remarks}')";

$data = Dynaset::execute($add_item);

$logs = "INSERT INTO IrrigAssetManagementLog (TransactionID, Category, Action, IPAddress, DateCreated, Encoder)
VALUES ('{$transactionID}','{$category}', 'Added and Item to the document number: {$documentNo}, Added By: {$encoder}', '{$ip}', GETDATE(), '{$encoder}')";


if($data){
    echo "Save Item";
    $log = Dynaset::execute($logs);
    
}
?>