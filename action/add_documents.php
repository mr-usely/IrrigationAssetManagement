<?php
require_once("../../../Initialization/initialize.php");

$id             = $_POST['ID'];
$ip = $_SERVER['REMOTE_ADDR'];
$assignee       = $_POST['Assignee'];
$documentType   = $_POST['DocumentType'];
$documentNo     = $_POST['DocumentNo'];
$categ          = $_POST['Category'];

$category = mssql_fetch_assoc(Dynaset::load("Select TransactionID, Category From IrrigDocument Where DocumentNo = '{$documentNo}'"));

$sql = ($category['Category'] == "New Document") ? Dynaset::execute("UPDATE IrrigDocument SET Assignee = '{$assignee}', DocumentType = '{$documentType}', DocumentNo = '{$documentNo}' WHERE PK = {$id}") :
Dynaset::execute("INSERT INTO IrrigDocument (Category, Assignee, DocumentType, DocumentNo) VALUES ('{$categ}','{$assignee}', '{$documentNo}', '{$documentNo}')");

$sql_log = "INSERT INTO IrrigAssetManagementLog (TransactionID, Category, Action, IPAddress, DateCreated, Encoder)
VALUES ('{$category['TransactionID']}','{$category['Category']}', 'Added a Document: {$documentNo}, Added By: {$assignee}', '{$ip}', GETDATE(), '{$assignee}')";

if($sql){
    $log = Dynaset::execute($sql_log);
    echo "Document Save";
}
?>