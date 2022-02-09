<?php
require_once("../../../Initialization/initialize.php");
$issuance = Dynaset::load("SELECT PK, TransactionID, Assignee, Encoder, TransactionDate FROM IrrigDocument WHERE Category = 'Issuance' AND TransactionID != ''")
?>

<div class="row">
    <div class="col-lg-12">
        <section class="content-header">
            <h1>
                Issuance <small>Report</small>
            </h1>
        </section>
    </div>
</div>
<div class="spacer"></div>
<hr class="style-four">
<table class="table table-hover table-condensed display" id="example3">
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
            while($row = mssql_fetch_assoc($issuance)){
                echo "<tr class='issuance-row data-row-{$row['PK']}' data-ids='{$row['PK']}'>";
                echo "<td>{$row['TransactionID']}</td>";
                echo "<td>{$row['Assignee']}</td>";
                echo "<td>{$row['Encoder']}</td>";
                echo "<td>{$row['TransactionDate']}";
                echo "<button type=\"button\" class=\"btn btn-danger btn-delete-issuance btn-sm btn-circle del-{$row['PK']} hide\" data-item=\"{$row['PK']}\" style=\"float: right; margin-right: 5px;\"><i class=\"glyphicon glyphicon-trash\"></i></button>";
                echo "</td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>

<script>
     $('#example3').DataTable( {
        bFilter: false, bInfo: false,
        "pagingType": "full_numbers"
    });

    $('.issuance-row').hover(function(){
        var data = $(this).data("ids");

        if($('.data-row-'+ data + ':hover').length != 0){
            $('.del-'+ data).removeClass('hide');
        } else {
            $('.del-'+ data).addClass('hide');
        }
    });

    $('.btn-delete-issuance').click(function(){
        var en = $(this).parents('tr.issuance-row').data("ids");
        let encoder     = "<?php echo $found_user->FirstName.' '.$found_user->LastName; ?>";

        $.ajax({
            url: 'action/del_doc.php',
            type: 'POST',
            data: {id: en, Category: category, Encoder: encoder},
            success: function(d){
                monitor();
                window.document.location = "?menu=dashboard";
            }
        });
    });
</script>