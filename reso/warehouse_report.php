<?php
require_once("../../../Initialization/initialize.php");

$warehouse = Dynaset::load("SELECT TransactionID, Encoder, DocumentNo, TransactionDate FROM IrrigDocument WHERE Category = 'Warehouse Delivery'")

?>

<div class="row">
    <div class="col-lg-12">
        <section class="content-header">
            <h1>
                Warehouse Delivery <small>Report</small>
            </h1>
        </section>
    </div>
</div>
<div class="spacer"></div>
<hr class="style-four">
<table class="table table-hover table-condensed display" id="example5">
    <thead>
        <tr>
            <th>Transaction ID</th>
            <th>Encoder</th>
            <th>Document No.</th>
            <th>Transaction Date</th>
        </tr>
    </thead>
    <tbody class="searchable">
        <?php
            while($row = mssql_fetch_assoc($warehouse)){
                echo "<tr>";
                echo "<td>{$row['TransactionID']}</td>";
                echo "<td>{$row['Encoder']}</td>";
                echo "<td>{$row['DocumentNo']}</td>";
                echo "<td>{$row['TransactionDate']}</td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>

<script>
     $('#example5').DataTable( {
        bFilter: false, bInfo: false,
        "pagingType": "full_numbers"
    });
</script>