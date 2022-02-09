<?php
require_once("../../../Initialization/initialize.php");
$found_user = Personnel::find_by_userid($session->UserID); 

$id         = $_POST['id'];
$ip         = $_SERVER['REMOTE_ADDR'];
$TRID       = $_POST['TransactionID'];
$DocType    = $_POST['DocumentType'];
$DocNo      = $_POST['DocumentNo'];
$encoder    = $found_user->FirstName.' '.$found_user->LastName;;

$category = mssql_fetch_assoc(Dynaset::load("Select Category From IrrigDocument Where PK = '{$id}'"));

$data = Dynaset::execute("UPDATE IrrigDocument SET DocumentType = '{$DocType}', DocumentNo = '{$DocNo}', ModifiedBy = '{$encoder}', ModifiedDate = GETDATE() WHERE PK = $id");

$save_log = "INSERT INTO IrrigAssetManagementLog (TransactionID, Category, Action, IPAddress, DateCreated, Encoder) VALUES ('{$TRID}', '{$category['Category']}', 'Update the Document No: {$DocNo}, Updated By: {encoder}', '{$ip}', GETDATE(), '{$encoder}')";

if($data){
    $log = Dynaset::execute($save_log);     // Save log
    echo "Update Document Successful!";
}
?>