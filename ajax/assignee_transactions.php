<?php
require_once("../../../Initialization/initialize.php");

$assign = $_GET['Assignee'];

$data = Dynaset::load("SELECT PK, DocumentType, DocumentNo FROM IrrigDocument WHERE Assignee = '$assign'");

while($row = mssql_fetch_assoc($data)){
    echo "<tr class='clickable-row document-row-{$row['PK']}' data-doc=\"{$row['PK']}\">";
    echo "<td>{$row['DocumentType']}</td>";
    echo "<td>{$row['DocumentNo']}";
    echo "<button type=\"button\" class=\"btn btn-success btn-sm btn-circle btn-additem document-{$row['PK']} hide\" data-additem=\"{$row['PK']}\" style=\"float: right; margin-left: 5px;\"><i class=\"glyphicon glyphicon-plus-sign\"></i></button>";
    echo "<button type=\"button\" class=\"btn btn-danger btn-sm btn-circle btn-delete document-{$row['PK']} hide\" data-del=\"{$row['PK']}\" style=\"float: right; margin-left: 5px;\"><i class=\"glyphicon glyphicon-trash\"></i></button>";
    echo "<button type=\"button\" class=\"btn btn-warning btn-sm btn-circle btn-update document-{$row['PK']} hide\" data-id=\"{$row['PK']},{$row['DocumentType']},{$row['DocumentNo']}\" style=\"float: right;\"><i class=\"glyphicon glyphicon-refresh\"></i></button>";
    echo "</td>";
    echo "</tr>";
}
?>

<script>

    jQuery(document).ready(function($) {

        // button Update
        $(".btn-update").click(function() {
            var data = $(this).data("id");
            var vals = data.split(",");
            TRID = "TRID110-"+vals[0];
            updatedoc = "true";

            document.getElementById('document_type').value  = vals[1];
            document.getElementById('doc_number').value     = vals[2];
            $('#doc_update').removeClass('hide');
            $('#update_cancel').removeClass('hide');

            $('#tbl_items').load('ajax/tbl_items.php?id=' + vals[0]);
            console.log('Document click ID: ' + vals[0]);
        });

        // button delete
        $(".btn-delete").click(function(){
            var pk = $(this).data("del");

            let encoder     = "<?php echo $found_user->FirstName.' '.$found_user->LastName; ?>";

            $.ajax({
                url: 'action/del_doc.php',
                type: 'POST',
                data: {id: pk, Category: category, Encoder: encoder},
                success: function(d){
                    console.log(d);
                    document.getElementById('document_type').value  = "";
                    document.getElementById('doc_number').value     = "";
                    assigneeTransactions();
                    refreshData();
                    monitor();
                }
            });
        });


        // add item button
        $('.btn-additem').click(function(){
            $('span.additem-doc-number').html('Document No: '+$('.document-row-'+$(this).data("additem")).find('td:nth-child(2)').text())

            $('#tbl_items').load('ajax/tbl_items.php?id=' + $(this).data("additem"))

            id = $(this).data("additem")    // set the ID
            TRID = "TRID110-"+id            // set the transaction ID
        });

        // hover over the table row and buttons will appear
        $('.clickable-row').hover(function(){
            var data = $(this).data("doc");

            if($('.document-row-' + data +':hover').length != 0){
                $('.document-' + data).removeClass('hide');
                $('td').css("vertical-align", "middle");
            } else {
                $('.document-' + data).addClass('hide');
            }
        });

        $('.clickable-row').each(function(){
            $(this).find('td:nth-child(2) button.btn-additem').popover({
                trigger: 'hover',
                html: true,
                container: 'body',
                content: 'Add Items to this document'
            })

            $(this).find('td:nth-child(2) button.btn-delete').popover({
                trigger: 'hover',
                html: true,
                container: 'body',
                content: 'Delete Document'
            })

            $(this).find('td:nth-child(2) button.btn-update').popover({
                trigger: 'hover',
                html: true,
                container: 'body',
                content: 'Update Document'
            })
        });
    });
</script>