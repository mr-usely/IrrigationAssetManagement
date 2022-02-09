<?php
require_once("../../../Initialization/initialize.php");
$balance = Dynaset::load("SELECT ItemNames, Description, Unit, CONVERT(varchar, CONVERT(money, TotalInventory), 1) TotalInventory FROM consIrrigItems WHERE ItemNames != ''");
?>

<div class="row">
    <div class="col-lg-12">
        <section class="content-header">
            <h1>
                Begining Balance
            </h1>
        </section>
    </div>
</div>
<div class="spacer"></div>
<hr class="style-four">
<table class="table table-hover table-condensed display" id="example6">
    <thead>
        <tr>
            <th>Item Names</th>
            <th>Unit</th>
            <th>Total Inventory</th>
        </tr>
    </thead>
    <tbody class="searchable">
        <?php
            while($row = mssql_fetch_assoc($balance)){
                echo "<tr class='item-name-row' data-details='{$row['Description']}'>";
                echo "<td title='Mixin Component'>{$row['ItemNames']}</td>";
                echo "<td>{$row['Unit']}</td>";
                echo "<td>{$row['TotalInventory']}</td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>

<script>
    $('#example6').DataTable({
        bFilter: false, bInfo: false,
        "pagingType": "full_numbers",
    });

    popOver();
    
    function popOver(){
        $('.item-name-row').each(function(){
            var val = $(this).data("details").replace(/,/g,"<br>");
            
            $(this).find('td:nth-child(2)').html() == 'SET/S' ?
            $(this).find('td:nth-child(1)').popover({
                trigger: 'hover',
                html: true,
                container: 'body',
                content: val ? val : 'none'
            }) : '';
        });
    }

    $('#example6_paginate').click(function(){popOver()});
</script>