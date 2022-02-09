
  <!-- Modal -->
  <div class="modal fade" id="modalTransaction" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" id="close_transact" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">COM WAREHOUSE STOCKS ENTRY</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                     <!-- Form -->
                     <form class="form-horizontal" id="transaction" method="POST" action="">
                        <!-- Radio Buttons -->
                        <div class="radio">
                            <label class="radio-inline"><input type="radio" name="issuance" id="issuance" onclick="radioIssuance();" value="Issuance" style="outline:none;" checked>Issuance</label>
                            <label class="radio-inline"><input type="radio" name="return" id="return" onclick="radioReturn();" value="Return" style="outline:none;" >Return</label>
                            <label class="radio-inline"><input type="radio" name="waredelivery" id="warehouse" onclick="radioWarehouse();" value="Warehouse Delivery" style="outline:none;" >Warehouse Delivery</label>
                        </div>
                        </br>
                   
                        <div class="form-group">
                            <div class="col-lg-7">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span>&nbsp; Assignee</span>
                                    <select class="form-control" id="assignee" name="assignee" onchange="assigneeTransactions();">
                                        <?php
                                            $cons_sql = "Select FarmerNo, Name, FarmAddress From tblULFS Where FarmerNo IN
                                            ('NABCOCZU2-0001','NABCOCZR7-0005','NABCOCJOC-0001','NABCOCZU5-0001',
                                            'NABCOCZU6-0001','NABCOCZU7-0001','NABCOCEME-0001','NABCOCZU9-0001',
                                            'NABCOCZV1-0001','NABCOCALA-0001','NABCOCORL-0001','NABCOCREG-0001')";
                                        
                                            $consAssignee = Dynaset::load($cons_sql);

                                            while($row = mssql_fetch_assoc($consAssignee)){
                                                echo "<option value=\"{$row['Name']}\">{$row['Name']}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>&nbsp; Transaction Date</span>
                                    <input type="date" class="form-control input-m" id="transact_date" name="transact_date" required/>	
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <hr class="style-four">
            <!-- Document Type -->
            <div class="row">
                <div class="col-lg-12">
                    <legend><h4>Documents</h4></legend>
                    <div class="alert alert-info hide" role="alert" id="document-alert" style="font-size: 12px;">Document is already Save Document Type: <b><span id="doc_type"></span></b>, Document No: <b><span id="doc_no"></span></b></div>
                    <form class="form-horizontal" method="POST" action="">
                        <div class="form-group">
                            <div class="col-lg-6">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-file"></span>&nbsp; Document Type</span>
                                    <select class="form-control" id="document_type" name="document_type">
                                        <?php
                                            $consDocu = Dynaset::load("Select * From consIrrigDocumentType");

                                            while($row = mssql_fetch_assoc($consDocu)){
                                                echo "<option value=\"{$row['DocumentType']}\">{$row['DocumentType']}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="input-group">
                                    <span class="input-group-addon">Document No.</span>
                                    <input type="text" class="form-control input-m" id="doc_number" name="doc_number" onkeydown="checkDoc();" value="" required/>	
                                </div>
                            </div>
                        </div>
                        
                        <!-- Buttons -->
                        <div class="col-lg-3 pull-right">
                            <!-- Submit Buttons -->
                            <button type="button" name="submit" id="doc_save" class="btn btn-success btn-sm">Save</button>
                            <button type="button" id="doc_cancel" class="btn btn-default btn-sm">Cancel</button>
                            <!-- Update Buttons -->
                            <button type="button" name="submit" id="doc_update" class="btn btn-warning btn-sm hide">Update</button>
                            <button type="button" id="update_cancel" class="btn btn-default btn-sm hide">Cancel</button>
                        </div><div class="spacer"></div>
                        
                    </form>
                </div>
                
                <!-- Document Type Table -->
                <div class="col-md-12">
                    <table class="table table-hover " id="example2">
                        <thead>
                            <tr>
                                <th>Document Type</th>
                                <th>Document No.</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_docu">
                        </tbody>
                    </table>
                </div>
            </div>

            <hr class="style-four">
            <!-- Item Details -->
            <div class="row">
                <div class="col-lg-12">
                    <legend><h4>Item Details <span class="additem-doc-number" style="margin-left: 450px;">Document No: </span></h4></legend>
                    <form class="form-horizontal" method="POST" action="">
                        <div class="form-group">
                            <div class="col-lg-7">
                                <div class="input-group">
                                    <span class="input-group-addon">Item Name</span>
                                    <select class="form-control" id="item_name" name="item_name" onchange="unitMeasurement();">
                                        <?php
                                            $consItemName = Dynaset::load("SELECT ItemNames FROM consIrrigItems");
                                            while($row = mssql_fetch_assoc($consItemName)){
                                                echo "<option value='{$row['ItemNames']}'>{$row['ItemNames']}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon" style="font-size: 13px;">Unit of Measurement</span>
                                    <input type="text" class="form-control input-m" id="unit_measure" name="unit_measure" readonly/>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon">Item Status</span>
                                    <select class="form-control" id="item_status" name="item_status">
                                        <?php
                                            $consItem = Dynaset::load("Select * From consIrrigItemStatus");

                                            while($row = mssql_fetch_assoc($consItem)){
                                                echo "<option value=\"{$row['ItemStatus']}\">{$row['ItemStatus']}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="input-group">
                                    <span class="input-group-addon">Quantity</span>
                                    <input type="number" class="form-control input-m" id="quantity" name="quantity" onkeypress="return isNumberKey(this, event);" required/>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <span class="input-group-addon">Remarks</span>
                                    <input type="text" class="form-control input-m" id="remarks" name="remarks" />
                                </div>
                            </div>
                        </div>
                        
                        <!-- Buttons -->
                        <div class="col-lg-3 pull-right">
                            <!-- Add Buttons -->
                            <button type="button" name="submit" id="add_items" class="btn btn-success btn-sm">Add</button>
                            <button type="button" class="btn btn-default btn-sm" id="cancel_items">Cancel</button>
                            
                            <!-- Update Buttons -->
                            <button type="button" name="submit" id="update_items" class="btn btn-warning btn-sm hide">Update</button>
                            <button type="button" class="btn btn-default btn-sm hide" id="cancel_update">Cancel</button>
                        </div>
                        <div class="spacer"></div>
                    </form>
                    <div class="spacer"></div>
                </div>

                <!-- Document Type Table -->
                <div class="col-md-12">
                    <table class="table table-hover table-condensed display" id="example">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Unit of Measurement</th>
                                <th>Item Status</th>
                                <th>Quantity</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_items">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success hide" name="submit" id="save_transact" ><span class="glyphicon glyphicon-floppy-saved"></span>&nbsp; Save</button> 
            <!-- | -->
          <button type="button" class="btn btn-default" id="close_transact2" data-dismiss="modal"><span class="glyphicon glyphicon-eye-close"></span>&nbsp; Close</button>
        </div>
      </div>
    </div>
  </div>