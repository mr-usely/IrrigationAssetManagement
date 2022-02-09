<?php
require_once("../../../Initialization/initialize.php");

$DRNo = $_POST['DRNo'];
$ip = $_SERVER['REMOTE_ADDR'];
$itemName = $_POST['ItemName'];
$receivedQuantity = $_POST['ReceivedQuantity'];
$receivedBy = $_POST['ReceivedBy'];

$category = mssql_fetch_assoc(Dynaset::load("Select TransactionID, Category From IrrigDocument Where DocumentNo = '{$DRNo}'"));


$sql = "Update IrrigItemNames Set ReceivedQuantity = {$receivedQuantity} WHERE PK IN (Select PK From IrrigItemNames";
$sql .= " WHERE ID IN (Select PK From IrrigDocument Where DocumentNo = '{$DRNo}') AND ItemName = '{$itemName}')";


$sql2 = "Update IrrigDocument SET DRStatus = 'Liquidated' WHERE DocumentNo = '{$DRNo}'";

$logs = "INSERT INTO IrrigAssetManagementLog (TransactionID, Category, Action, IPAddress, DateCreated, Encoder)
VALUES ('{$category['TransactionID']}','{$category['Category']}', 'Liquidated the document number: {$DRNo}, Received By: {$receivedBy}', '{$ip}', GETDATE(), '{$receivedBy}')";

$exec = Dynaset::execute($sql);

if($exec){
    
    $exec   =  Dynaset::execute($sql2);
    $log    =  Dynaset::execute($logs);
    echo $receivedQuantity;

}
?>