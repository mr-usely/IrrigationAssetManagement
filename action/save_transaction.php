<?php
require_once("../../../Initialization/initialize.php");
$found_user = Personnel::find_by_userid($session->UserID); 

$id         =   $_POST['ID'];
$ip         =   $_SERVER['REMOTE_ADDR'];
$TRID       =   $_POST['TransactionID'];
$category   =   $_POST['Category'];
$assignee   =   $_POST['Assignee'];
$trans_date =   $_POST['Transact_Date'];
$docType    =   $_POST['DocumentType'];
$docNo      =   $_POST['DocumentNo'];
$encoder    =   $found_user->FirstName.' '.$found_user->LastName;

// Update table IrrigDocument
$doc_sql  = "UPDATE IrrigDocument SET Category = '{$category}', Assignee = '{$assignee}', TransactionDate = '{$trans_date}', ";
$doc_sql .= "DocumentType = '{$docType}', DocumentNo = '{$docNo}', IPAddress = '{$ip}', Encoder = '{$encoder}', TransactionID = '{$TRID}' WHERE PK = {$id}";

$save_log = "INSERT INTO IrrigAssetManagementLog (TransactionID, Category, Action, IPAddress, DateCreated, Encoder) VALUES ('{$TRID}', '{$category}', 'Save Transaction DocumentNo: {$docNo}, Encoder: {$encoder}', '{$ip}', GETDATE(), '{$encoder}')";

// Update table IrrigItemNames
$item_sql = "UPDATE IrrigItemNames SET Category = '{$category}' WHERE ID = {$id}";


// SQL Script for Issuance
$sql_issuance = "UPDATE Items SET Items.TotalInventory = Items.TotalInventory - ItemN.Quantity FROM consIrrigItems Items
INNER JOIN IrrigItemNames ItemN ON Items.ItemNames = ItemN.ItemName WHERE ID = {$id}";

// SQL Script for Returns
$sql_returns = "UPDATE Items SET Items.TotalInventory = Items.TotalInventory + ItemN.Quantity FROM consIrrigItems Items
INNER JOIN IrrigItemNames ItemN ON Items.ItemNames = ItemN.ItemName WHERE ID = {$id}";

// SQL Script for Warehouse Delivery
$sql_delivery = "UPDATE Items SET Items.TotalInventory = Items.TotalInventory + ItemN.Quantity FROM consIrrigItems Items
INNER JOIN IrrigItemNames ItemN ON Items.ItemNames = ItemN.ItemName WHERE ID = {$id}";


$exec_update1 = ($category == "Issuance")               ?   Dynaset::execute($sql_issuance)     : '';
$exec_update2 = ($category == "Return")                 ?   Dynaset::execute($sql_returns)      : '';
$exec_update3 = ($category == "Warehouse Delivery")     ?   Dynaset::execute($sql_delivery)     : '';

if($exec_update1 || ($exec_update2 || $exec_update3)){
    echo "Save Successful";

    $execute1   =   Dynaset::execute($doc_sql);     // table IrrigDocument
    $execute2   =   Dynaset::execute($item_sql);    // table IrrigItemNames
    $log        =   Dynaset::execute($save_log);    // Save logs
    
}
?>