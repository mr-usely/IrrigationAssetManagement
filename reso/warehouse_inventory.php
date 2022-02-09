<div class="row">
    <div class="col-lg-6">
        <section class="content-header">
            <h1>
                Warehouse Inventory Summary
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
                        <span class="input-group-addon">Farm Number</span>
                        <select class="form-control" id="farm_numbers" onchange="loadReport();">
                            <option value="">-- Select --</option>
                            <?php
                                $ssql = "Select Distinct rep.FarmerNo, FarmAddress, assignee.FSName From tblULFS assignee
                                Inner Join consIrrigAuthorizedRep rep ON assignee.FarmerNo = rep.FarmerNo
                                Where ApprovalStatus = 'APPROVED' AND BackOut = 0 AND SupplierTypeID = 'COC'
                                Order By FSName";
                                $dr_numbers = Dynaset::load($ssql);
                                while($row = mssql_fetch_assoc($dr_numbers)){
                                    echo "<option value=\"{$row['FarmerNo']}\">{$row['FarmerNo']}</option>";
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


<div class="row">
    <div class="col-md-12">
        <table class="table table-hover" id="forLiquidation">
            <thead>
                <tr>
                    <th rowspan="2">Phase</th>
                    <th rowspan="2">Assembly (Proposed New Name)</th>
                    <th rowspan="2">Description Of Goods</th>
                    <th rowspan="2">Unit</th>
                    <th rowspan="2">Classification</th>
                    <th rowspan="2">Total Issuance</th>
                    <th colspan="5" style="text-align: center;">TOTAL RETURNS</th>
                    <th rowspan="2">Returns</th>
                </tr>
                <tr>
                    <th>Used</th>
                    <th>For Repair</th>
                    <th>Damaged/Scrap</th>
                    <th>Total</th>
                    <th>Total Returns</th>
                </tr>
            </thead>
            <tbody class="tbl-report">
            </tbody>
        </table>
    </div>
</div>

<script>
    function loadReport(){
        $('.tbl-report').load('ajax/tbl_warehouse_inventory.php?farm_number='+$('#farm_numbers').val());
        console.log();
    }
</script>