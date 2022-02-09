<?php
require_once("../../../Initialization/initialize.php");

$test = $_POST['name'];
$data = Dynaset::execute("INSERT INTO IrrigDocument (Category, DateCreated) VALUES ('New Document', GETDATE())");

$getpk = Dynaset::load("SELECT TOP 1 PK FROM IrrigDocument ORDER BY PK DESC");
$row = mssql_fetch_assoc($getpk);
if($data){
    echo $row['PK'];
}
?>