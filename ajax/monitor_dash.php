<?php
require_once("../../../Initialization/initialize.php");

$sql = "SELECT SUM(Issuance) Issuance, SUM(Returns) Returns, SUM(WarehouseDelivery) WarehouseDelivery,
CONVERT(varchar, CONVERT(money,(SELECT SUM(TotalInventory) TotalInventory FROM consIrrigItems)), 1) TotalInventory FROM (
	SELECT CASE WHEN Category = 'Issuance' Then (SELECT COUNT(*) FROM IrrigDocument WHERE Category = 'Issuance') Else 0 End Issuance,
			CASE WHEN Category = 'Return' Then (SELECT COUNT(*) FROM IrrigDocument WHERE Category = 'Return') Else 0 End Returns,
			CASE WHEN Category = 'Warehouse Delivery' Then (SELECT COUNT(*) FROM IrrigDocument WHERE Category = 'Warehouse Delivery') Else 0 End WarehouseDelivery
	FROM IrrigDocument WHERE Category IN ('Issuance', 'Return', 'Warehouse Delivery') AND TransactionID != '' GROUP BY Category
) A ";

$data = Dynaset::load($sql);

$row = mssql_fetch_array($data);

if($data){
    echo $row['Issuance'].','.$row['Returns'].','.$row['WarehouseDelivery'].','.$row['TotalInventory'];
}
?>