<?php
require_once("../../../Initialization/initialize.php");

$pk = $_POST['PK'];

$data   = Dynaset::load("SELECT * FROM IrrigItemNames WHERE PK = {$pk}");
$row    = mssql_fetch_assoc($data);
echo
?>