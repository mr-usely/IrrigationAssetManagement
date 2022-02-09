
      //Global Variables
      var id        = "";       // Document ID for tracking 
      var category  = "";       // To Identify what category of the document
      var doc       = "false";  // To know if the document type has redered data
      var doc_Type  = "";       // To fill Document Type input
      var doc_No    = "";       // To fill Document No input
      var assignee  = "";
      var TRID      = "";
      var updatedoc = "false";
      var today = new Date();
      var dd = String(today.getDate()).padStart(2, '0');
      var mm = String(today.getMonth() + 1).padStart(2, '0');
      var yyyy = today.getFullYear();

      today = yyyy + '-' + mm + '-' + dd; // Date
      

      // Add multiple Values at a time 
      function addValues(){
        let itemName          = document.getElementById('item_name').value;
        let unitMeasurement   = document.getElementById('unit_measure').value;
        let itemStatus        = document.getElementById('item_status').value;
        let quantity          = document.getElementById('quantity').value;
        let remarks           = document.getElementById('remarks').value;
        var items             = "";

        if(item == ""){
            item = "("+ id + ", 'New Document'" + ", '" + itemName + "', '" + unitMeasurement + "', '" + itemStatus + "'," + quantity + ", '" + remarks + "')";
            console.log(item);
        } else if (item != ""){
            items = ",("+ id + ", 'New Document'" + ", '" + itemName + "', '" + unitMeasurement + "', '" + itemStatus + "'," + quantity + ", '" + remarks + "')";
            item += items;
            console.log(item);
        }
      }


    // Get Document PK and turn it to id
      function getID(){  
            $.ajax({
                url: 'action/doc.php',
                type: 'POST',
                data: {name: 'test'},
                dataType: 'html',
                success: function(data){
                    id = data;
                    TRID = "TRID110-"+data;
                    assignee = "";
                    refreshData();
                    document.getElementById('assignee').value       =    "";
                    document.getElementById('document_type').value  =    "";
                    document.getElementById('item_name').value      =    "";
                    document.getElementById('unit_measure').value   =    "";
                    document.getElementById('item_status').value    =    "";
                    document.getElementById('quantity').value       =    "";
                    document.getElementById('remarks').value        =    "";
                    console.log(id);
                }
            });
      }


      // Cancel current transaction
      function cancelData(){
            $.ajax({
                url: 'action/del_doc.php',
                type: 'POST',
                data: {id: id, Category: 'New Document'},
                dataType: 'html',
                success: function(data){
                    console.log(data);
                }
            });
      }

      // Check assignees transaction Documents and Item Names
      function assigneeTransactions(){
            assignee = document.getElementById('assignee').value;
            
            let link = "ajax/assignee_transactions.php?Assignee=" + assignee;
            
            $('#tbl_docu').load(link.replace(/ /g, '%20'));
            
            $('#save_transact').show();
            
            $.ajax({
                url: 'ajax/check_assignee.php',
                type: 'POST',
                data: {assignee: assignee},
                success: function(res){
                    var vals = res.split(",");
                    
                    if(vals[0] == "Success" && vals[1] != ""){
                        console.log(vals[1]);
                        TRID = vals[1];
                        $('#save_transact').addClass("hide");
                        $('#tbl_docu').load(link.replace(/ /g, '%20'));
                    } else {
                        TRID = "TRID110-"+id;
                        console.log("Transaction ID: "+TRID);
                        console.log(assignee);
                        $('#save_transact').removeClass("hide");
                    }
                }
            });
      }

      function unitMeasurement(){
          let unitItem    =     document.getElementById('item_name').value;
          $.ajax({
              url: 'ajax/get_unit.php',
              type: 'POST',
              data: {ItemName: unitItem},
              dataType: 'html',
              success: function(data){
                  console.log(data);
                  document.getElementById('unit_measure').value    =    data;
              }
          });
      }


      // Add Items
      function addItems(){
        let itemName          = document.getElementById('item_name').value;
        let unitMeasurement   = document.getElementById('unit_measure').value;
        let itemStatus        = document.getElementById('item_status').value;
        let quantity          = document.getElementById('quantity').value;
        let remarks           = document.getElementById('remarks').value;
        
        var items ="";

        if(items == ""){
            items = "("+ id + ", 'New Document'" + ", '" + itemName + "', '" + unitMeasurement + "', '" + itemStatus + "'," + quantity + ", '" + remarks + "')";
            console.log(items);
        }

        $.ajax({
            url: 'action/add_item.php',
            type: 'POST',
            data: {
                ID: id,
                Category: (category == "") ? 'New Document' : category,
                ItemName: itemName,
                UnitMeasurement: unitMeasurement,
                ItemStatus: itemStatus,
                Quantity: quantity,
                Remarks: remarks,
                DocumentNo: $('#doc_type').html(),
                TransactionID: TRID
            },
            dataType: 'html',
            success: function(data){
                items = "";
                document.getElementById('item_name').value      = "";
                document.getElementById('unit_measure').value   = "";
                document.getElementById('item_status').value    = "";
                document.getElementById('quantity').value       = "";
                document.getElementById('remarks').value        = "";
                console.log(data);
            }
        });

      }


      // Refresh table Item names
      function refreshData(){
          $('#tbl_items').load('ajax/tbl_items.php?id='+id);
      }

      // Button Add Items
      $('#add_items').click(function(){
        addItems();
        refreshData();
      });

      // Button Update Items
      $('#update_items').click(function(){
        let itemName          = document.getElementById('item_name').value;
        let unitMeasurement   = document.getElementById('unit_measure').value;
        let itemStatus        = document.getElementById('item_status').value;
        let quantity          = document.getElementById('quantity').value;
        let remarks           = document.getElementById('remarks').value;

        $.ajax({
            url: 'action/update_items.php',
            type: 'POST',
            data: {
                ID: id,
                ItemNames: itemName,
                UnitMeasurement: unitMeasurement,
                ItemStatus: itemStatus,
                Quantity: quantity,
                Remarks: remarks
                },
            success: function(d){
                console.log(d);

                if(d == "Update Success!"){
  
                    $('#update_items').addClass("hide");
                    $('#cancel_update').addClass("hide");
                    $('#add_items').removeClass("hide");
                    $('#cancel_items').removeClass("hide");

                    document.getElementById('item_name').value           = "";
                    document.getElementById('unit_measure').value        = "";
                    document.getElementById('item_status').value         = "";
                    document.getElementById('quantity').value            = "";
                    document.getElementById('remarks').value             = "";

                    refreshData();
                }
            }
        });
      });

      $('#cancel_update').click(function(){

            $('#update_items').addClass("hide");
            $('#cancel_update').addClass("hide");
            $('#add_items').removeClass("hide");
            $('#cancel_items').removeClass("hide");

            document.getElementById('item_name').value           = "";
            document.getElementById('unit_measure').value        = "";
            document.getElementById('item_status').value         = "";
            document.getElementById('quantity').value            = "";
            document.getElementById('remarks').value             = "";

      });


      // Radio Buttons
      function radioIssuance(){
          document.getElementById('issuance').checked   = true;
          document.getElementById('return').checked     = false;
          document.getElementById('warehouse').checked  = false;
          document.getElementById('assignee').disabled  = false;
          $('#save_transact').hide();

          if(document.getElementById('issuance').checked){
            category = document.getElementById('issuance').value;
          }
          console.log(category);
      }

      function radioReturn(){
          document.getElementById('issuance').checked  = false;
          document.getElementById('return').checked    = true;
          document.getElementById('warehouse').checked = false;
          document.getElementById('assignee').disabled = false;
          $('#save_transact').hide();

          if(document.getElementById('return').checked){
            category = document.getElementById('return').value;
          }
          console.log(category);
      }

      function radioWarehouse(){
          document.getElementById('issuance').checked  = false;
          document.getElementById('return').checked    = false;
          document.getElementById('warehouse').checked = true;
          document.getElementById('assignee').disabled = true;
          document.getElementById('assignee').value    = "";
          $('#save_transact').removeClass("hide");
          $('#save_transact').show();

          if(document.getElementById('warehouse').checked){
            category = document.getElementById('warehouse').value;
          }
          console.log(category);
      }


      // Save Document Type and Document No.
      $('#doc_save').click(function(){
        assignee        = document.getElementById('assignee').value;
        let docType     = document.getElementById('document_type').value;
        let docNo       = document.getElementById('doc_number').value;
        
        doc_Type    = docType;
        doc_No      = docNo;
        
        $.ajax({
            url: 'action/add_documents.php',
            type: 'POST',
            data: {
                ID: id,
                Assignee: assignee,
                DocumentType: doc_Type,
                DocumentNo: doc_No,
                Category: category
            },  
            success: function(res){
                console.log(res);

                if(res == "Document Save"){
                    document.getElementById('document-alert').style.transition  = "all 2s"
                    document.getElementById('document_type').value              = "";
                    document.getElementById('doc_number').value                 = "";
                    $('#document-alert').removeClass('hide');
                    $('#doc_save').addClass('hide');
                    $('#doc_cancel').addClass('hide');
                    
                    document.getElementById('doc_type').innerHTML   = docType;
                    document.getElementById('doc_no').innerHTML     = docNo;
                    docType = "";
                    docNo   = "";
                }
                
                assigneeTransactions();
            }
        });
      });


    // Update document button
      $('#doc_update').click(function(){
        let docType     = document.getElementById('document_type').value;
        let docNo       = document.getElementById('doc_number').value;

        $.ajax({
            url: 'action/update_doc.php',
            type: 'POST',
            data: {
                id: id,
                TransactionID: TRID,
                DocumentType: docType,
                DocumentNo: docNo
            },
            dataType: 'html',
            success: function(res){
                console.log(res);
                assigneeTransactions();
                refreshData();
            }
        });
      });


      // update cancel
      $('#update_cancel').click(function(){
        
        $('#update_cancel').addClass("hide");
        $('#doc_update').addClass("hide");
        document.getElementById('document_type').value  = "";
        document.getElementById('doc_number').value     = "";

      });


      // Save Current transaction
      $('#save_transact').click(function(){
        
        // Get all the variables and data
        let assignee    = document.getElementById('assignee').value;
        let trans_date  = document.getElementById('transact_date').value;


        $.ajax({
            url: 'action/save_transaction.php',
            type: 'POST',
            data:{
                ID: id,
                TransactionID: (TRID == "") ? "TRID110-"+id : TRID,
                Category: category,
                Assignee: assignee,
                Transact_Date: (trans_date == "") ? today : trans_date,
                DocumentType: doc_Type,
                DocumentNo: doc_No
            },
            dataType: 'html',
            success: function(data){
                if(data == "Save Successful"){
                    console.log(data);
                    getID();
                    docCancel();
                    refreshData();
                    monitor();
                    assigneeTransactions();

                    $('#save_transact').addClass("hide");
                } else {
                    console.log('data not save');
                    console.log(data);
                }
            }
        });

      });

      // Open Modal Form
      $('#open_transact').click(function(){
          // when transaction is open, get transaction ID
          getID();
      });


      // Close Modal Form close button
      $('#close_transact').click(function(){
          cancelData();
          $('#doc_save').removeClass('hide');
          $('#doc_cancel').removeClass('hide');
          $('#save_transact').addClass("hide");
          document.getElementById('doc_type').innerHTML   = "";
          document.getElementById('doc_no').innerHTML     = ""; 
          item = "";
      });


      // Close Modal Form X icon
      $('#close_transact2').click(function(){
          cancelData();
          $('#doc_save').removeClass('hide');
          $('#doc_cancel').removeClass('hide');
          $('#save_transact').addClass("hide");
          document.getElementById('doc_type').innerHTML   = "";
          document.getElementById('doc_no').innerHTML     = "";
          item = "";
      });


      function docCancel(){
        document.getElementById('doc_number').value     = "";
        document.getElementById('doc_type').innerHTML   = "";
        document.getElementById('doc_no').innerHTML     = "";
        $('#doc_save').addClass('hide');
        $('#doc_cancel').addClass('hide');
        $('#document-alert').addClass('hide');
      }

      $('#doc_cancel').click(function(){
        docCancel();
        checkDoc();
      });

      
      function checkDoc(){
          if(document.getElementById('doc_number').value != "" && updatedoc == "false"){
            $('#doc_save').removeClass('hide');
            $('#doc_cancel').removeClass('hide');
          } else {
            $('#doc_save').addClass('hide');
            $('#doc_cancel').addClass('hide');
          }
      }