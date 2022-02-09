<?php
require_once("../../../Initialization/initialize.php");

$id = $_GET['id'];

$data = Dynaset::load("SELECT * FROM IrrigItemNames WHERE ID = {$id}");

while($row = mssql_fetch_assoc($data)){
    echo "<tr class='clickable-row2 doc-row-{$row['PK']}' data-id2=\"{$row['PK']},{$row['ItemName']},{$row['UnitMeasurement']},{$row['ItemStatus']},{$row['Quantity']},{$row['Remarks']}\">";
    echo "<td>{$row['ItemName']}</td>";
    echo "<td>{$row['UnitMeasurement']}</td>";
    echo "<td>{$row['ItemStatus']}</td>";
    echo "<td>{$row['Quantity']}</td>";
    echo "<td>{$row['Remarks']}";
    echo "<button type=\"button\" class=\"btn btn-danger btn-delete-item btn-sm btn-circle doc-{$row['PK']} hide\" data-item=\"{$row['PK']}\" style=\"float: right; margin-left: 5px;\"><i class=\"glyphicon glyphicon-trash\"></i></button>";
    echo "<button type=\"button\" id=\"item_update\" class=\"btn btn-warning btn-sm btn-circle item_update doc-{$row['PK']} hide\" data-array=\"{$row['PK']},{$row['ItemName']},{$row['UnitMeasurement']},{$row['ItemStatus']},{$row['Quantity']},{$row['Remarks']}\" style=\"float: right;\"><i class=\"glyphicon glyphicon-refresh\"></i></button>";
    echo "</td>";
    echo "</tr>";
}

?>

<script>
jQuery(document).ready(function($){
    $('.item_update').click(function(){
        var data = $(this).data("array");
        var vals = data.split(",");


        document.getElementById('item_name').value      = vals[1];
        document.getElementById('unit_measure').value   = vals[2];
        document.getElementById('item_status').value    = vals[3];
        document.getElementById('quantity').value       = vals[4];
        document.getElementById('remarks').value        = vals[5];

        $('#update_items').removeClass("hide");
        $('#cancel_update').removeClass("hide");
        $('#add_items').addClass("hide");
        $('#cancel_items').addClass("hide");
    });

    $('.clickable-row2').hover(function(){
        var data = $(this).data("id2");
        var vals = data.split(",");

        if($('.doc-row-' + vals[0] +':hover').length != 0 ){
            $('.doc-' + vals[0]).removeClass('hide');
            $('td').css("vertical-align", "middle");
        } else {
            $('.doc-' + vals[0]).addClass('hide');
        }
    });

    $('.btn-delete-item').click(function(){
        var pk = $(this).data("item");

        $.ajax({
            url: 'action/del_items.php',
            type: 'POST',
            data: {id: pk},
            success: function(d){
                console.log(d);
                refreshData();
            }
        });
    });

    $('.clickable-row2').each(function(){
        $(this).find('td:nth-child(5) button.item_update').popover({
            trigger: 'hover',
            html: true,
            container: 'body',
            content: 'Update Item'
        })

        $(this).find('td:nth-child(5) button.btn-delete-item').popover({
            trigger: 'hover',
            html: true,
            container: 'body',
            content: 'Delete Item'
        })
    });
});
</script>