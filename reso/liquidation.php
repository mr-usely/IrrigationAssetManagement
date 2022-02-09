<div class="row">
    <div class="col-lg-6">
        <section class="content-header">
            <h1>
                DR Liquidation
            </h1>
        </section>
    </div>
</div>
<div class="spacer"></div>
<hr class="style-four">
<div class="row">
    <div class="col-md-8">
        <legend><h4>Filter Options</h4></legend>
        <form class="form-horizontal" method="POST" action="">
            <div class="form-group">
                <div class="col-lg-5">
                    <div class="input-group">
                        <span class="input-group-addon">DR Number</span>
                        <select class="form-control" id="dr_numbers" >
                            <option value="">-- Select --</option>
                            <?php

                                $dr_numbers = Dynaset::load("SELECT DocumentNo FROM IrrigDocument WHERE Category != 'New Document'");
                                while($row = mssql_fetch_assoc($dr_numbers)){
                                    echo "<option value=\"{$row['DocumentNo']}\">{$row['DocumentNo']}</option>";
                                }

                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="input-group">
                        <span class="input-group-addon">Assignee</span>
                        <select class="form-control" id="assignees">
                            <option value="">-- Select --</option>
                            <?php

                                $dr_numbers = Dynaset::load("SELECT Assignee FROM IrrigDocument WHERE Category != 'New Document'");
                                while($row = mssql_fetch_assoc($dr_numbers)){
                                    echo "<option value=\"{$row['Assignee']}\">{$row['Assignee']}</option>";
                                }

                            ?>
                        </select>
                    </div>
                </div>
                <!-- <button type="button" id="filters" class="btn btn-primary btn-sm" ><span class="glyphicon glyphicon-filter"></span>&nbsp; Filter
                </button> -->
            </div>
        </form>
    </div>
</div>

<!-- DR for Liquidation table -->
<div class="row">
    <div class="col-md-12">
        <table class="table table-hover" id="forLiquidation">
            <thead>
                <tr>
                    <th>DR Number</th>
                    <th>Assignee</th>
                    <th>Transaction Date</th>
                    <th>DR Status</th>
                </tr>
            </thead>
            <tbody class="filter-liquidate">

            <?php
                $encodedDR = Dynaset::load("SELECT PK, DocumentNo, Assignee, TransactionDate, DRStatus FROM IrrigDocument WHERE Assignee != '' AND Category NOT IN ('New Document', '')");
                while($row = mssql_fetch_assoc($encodedDR)){
                    echo "<tr class='liquidate-row liquidate-row-{$row['PK']}' data-liquidate='{$row['PK']}'>";
                    echo "<td>{$row['DocumentNo']}</td>";
                    echo "<td>{$row['Assignee']}</td>";
                    echo "<td>{$row['TransactionDate']}</td>";
                    echo "<td>";
                    echo "<span class='label' id='label-status'>{$row['DRStatus']}</span>";
                    echo "<span class='glyphicon glyphicon-open-file text-muted clickable-icon liquidate-{$row['PK']} hide pointer' data-toggle='modal' data-target='#modalLiquidate' style='float: right; margin-right: 20px; font-size: 20px;' ></span>";
                    echo "</td>";
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script>
$(document).ready(function(){
   (function($){
       $('#dr_numbers').change(function(){
           var rex = new RegExp($(this).val(), 'i');
           $('.filter-liquidate tr').hide();
           $('.filter-liquidate tr').filter(function (){
               return rex.test($(this).text());
           }).show();
       })

       $('#assignees').change(function(){
           var rex = new RegExp($(this).val(), 'i');
           $('.filter-liquidate tr').hide();
           $('.filter-liquidate tr').filter(function (){
               return rex.test($(this).text());
           }).show();
       })

   }(jQuery));
});
</script>

<script>

jQuery(document).ready(function($){

    $('tr.liquidate-row').find('td span.label').each(function(){

        ($(this).html() == "For Liquidation")?
        $(this).addClass('label-warning'):
        ($(this).html() == "Liquidated")?
        $(this).addClass('label-success'):'';

    });

    $('.liquidate-row').hover(function(){
        var id = $(this).data("liquidate");
        if($('.liquidate-row-'+ id +':hover').length != 0){
            $('.liquidate-'+id).removeClass('hide');
        } else {
            $('.liquidate-'+id).addClass('hide');
        }
    });

    $('.clickable-icon').click(function(){

        $('center').find('h4.modal-title').html('Document No: '+$(this).parents('tr').find('td:nth-child(1)').html());
        $('#liquidate-name').val($(this).parents('tr').find('td:nth-child(2)').html());
        $('#liquidate-date').val($(this).parents('tr').find('td:nth-child(3)').html());
        $('#tbl-liquidate').load('ajax/tbl_liquidate.php?DRNo='+$(this).parents('tr').find('td:nth-child(1)').html());

    });
});
</script>

<div class="modal fade" id="modalLiquidate" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" id="close-liquidation" class="close" data-dismiss="modal">&times;</button>
                <center><h4 class="modal-title"></h4></center>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group">
                        <div class="col-lg-7">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span>&nbsp; Assignee</span>
                                <input type="text" class="form-control input-m" id="liquidate-name" name="assigee" readonly>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>&nbsp; Transaction date</span>
                                <input type="date" class="form-control input-m" id="liquidate-date" name="assigee" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="spacer"></div>
                <div class="row">
                    <div class="col-lg-12">
                        <legend><h4>Item Details</h4></legend>
                        <table class="table table-hover" id="item-details">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Unit of Measurement</th>
                                    <th>Item Status</th>
                                    <th>Quantity</th>
                                    <th>Remarks</th>
                                    <th>Received Quantity</th>
                                </tr>
                            </thead>
                            <tbody id="tbl-liquidate">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row hide" id="show-received">
                    <div class="form-group">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <span class="input-group-addon">Received By:</span>
                                <select class="form-control input-m" id="received-by" name="received-by">
                                    <option value="">-- Select --</option>
                                    <?php
                                        $farmers = Dynaset::load("Select FarmerNo, Name From consIrrigAuthorizedRep");
                                        
                                        while($row = mssql_fetch_array($farmers)){
                                            echo "<option value='{$row['Name']}'>{$row['FarmerNo']} - {$row['Name']}</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" name="submit" id="liquidate-item" ><span class="glyphicon glyphicon-floppy-saved"></span>&nbsp; Liquidate</button>
                <button type="button" class="btn btn-success hide" name="submit" id="save-item" ><span class="glyphicon glyphicon-save-file"></span>&nbsp; Save</button>
                <button type="button" class="btn btn-default" id="close-liquidate-item" data-dismiss="modal"><span class="glyphicon glyphicon-eye-close"></span>&nbsp; Close</button>
            </div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function(){
    $('#item-details').DataTable({
        bFilter: false, bInfo: false,
            "paging":   true,
            "ordering": true,
            "info":     false
    });

    $('#liquidate-item').click(function(){
        $('#liquidate-item').addClass("hide");
        $('#save-item').removeClass("hide");
        $('#show-received').removeClass("hide");

        $('.editableRow').find('td.editableColumn').each(function(){
            var html = $(this).html();
            var input = $('<input class="form-control editableColumnStyle" type="text" onkeypress="return isNumberKey(this, event);" />');
            input.val(html);
            $(this).html(input);
        });
    });

    $('#save-item').click(function(){
        $('#save-item').addClass("hide");
        $('#liquidate-item').removeClass("hide");
        $('#show-received').addClass("hide");

        $('.editableRow').find('td.editableColumn').each(function(){
            $(this).parents('tr').find('td:nth-child(1)').each(function(){
                var value = $(this).parents('tr.editableRow').find('.editableColumnStyle').val();

                $.ajax({
                    url: 'action/liquidate_item.php',
                    type: 'POST',
                    data: {
                        ItemName: $(this).html(),
                        DRNo: $('tr.liquidate-row').find('td:nth-child(1)').html(),
                        ReceivedQuantity: value,
                        ReceivedBy: $('#received-by').val()
                    },
                    success: function(res){
                        console.log(res);
                        window.document.location = "?menu=liquidation";
                    }
                });
            });
            $(this).html($('.editableColumnStyle').val());
        });
    });
});
</script>