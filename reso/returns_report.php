<?php
require_once("../../../Initialization/initialize.php");

$returns = Dynaset::load("SELECT TransactionID, Assignee, Encoder, TransactionDate FROM IrrigDocument WHERE Category = 'Return'")
?>

<div class="row">
    <div class="col-lg-12">
        <section class="content-header">
            <h1>
                Returns <small>Report</small>
            </h1>
        </section>
    </div>
</div>
<div class="spacer"></div>
<hr class="style-four">
<table class="table table-hover table-condensed display" id="example4"">
    <thead>
        <tr>
            <th>Transaction ID</th>
            <th>Assignee</th>
            <th>Encoder</th>
            <th>Transaction Date</th>
        </tr>
    </thead>
    <tbody class="searchable">
        <?php
            while($row = mssql_fetch_assoc($returns)){
                echo "<tr>";
                echo "<td>{$row['TransactionID']}</td>";
                echo "<td>{$row['Assignee']}</td>";
                echo "<td>{$row['Encoder']}</td>";
                echo "<td>{$row['TransactionDate']}</td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>

<script>
    $('#example4').DataTable( {
        bFilter: false, bInfo: false,
        "pagingType": "full_numbers"
    });
</script>