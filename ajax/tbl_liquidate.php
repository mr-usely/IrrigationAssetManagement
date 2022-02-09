<?php
require_once("../../../Initialization/initialize.php");

$DRNo = $_GET['DRNo'];

$sql = Dynaset::load("SELECT ItemName, UnitMeasurement, ItemStatus, Quantity, Remarks, ReceivedQuantity FROM IrrigitemNames WHERE ID IN (SELECT PK FROM IrrigDocument WHERE DocumentNo = '{$DRNo}')");

while($row = mssql_fetch_assoc($sql)){
    echo "<tr class='editableRow'>";
    echo "<td>{$row['ItemName']}</td>";
    echo "<td>{$row['UnitMeasurement']}</td>";
    echo "<td><span class='label'>{$row['ItemStatus']}</span></td>";
    echo "<td>{$row['Quantity']}</td>";
    echo "<td>{$row['Remarks']}</td>";
    echo "<td class='editableColumn'>{$row['ReceivedQuantity']}</td>";
    echo "</tr>";
}
?>

<script>
    jQuery(document).ready(function(){
        
        $('tr.editableRow').find('td:nth-child(3) span.label').each(function(){
            $(this).html()   == "New"             ?   $(this).addClass('label-success') :
            $(this).html()   == "Used"            ?   $(this).addClass('label-primary') :
            $(this).html()   == "For Repair"      ?   $(this).addClass('label-warning') :
            $(this).html()   == "Damaged/Scrap"   ?   $(this).addClass('label-danger')  :
            '';
        });

    });
</script>