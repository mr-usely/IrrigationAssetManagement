          

            <!-- Modal -->
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Save Success</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
                <hr class="style-four">
                <footer class="footer">    
                    <p class="text-muted pull-left">Universal Leaf Philippines Inc. &copy 2021</p>
                    <p class="text-muted pull-right">Designed and Developed by <a href="">SSDG</a></p>
                </footer>
                <div class="spacer"></div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->
    
    <!-- jQuery -->
    <script src="base/js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="base/js/bootstrap.min.js"></script>
    <!-- asset form -->
    <script src="base/js/form.js"></script>
    
    <!-- Menu Toggle Script -->
    <script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>
    <!-- Chart js library -->
    <script src="base/js/chart/Chart.js"></script>
    
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

    <script>
       $(document).ready(function() {
        $('#example').DataTable( {
            bFilter: false, bInfo: false,
            "pagingType": "full_numbers"
        });
        
        $('#example2').DataTable( {
            bFilter: false, bInfo: false,
            "paging":   true,
            "ordering": true,
            "info":     false
        });

        $('#forLiquidation').DataTable({
            bFilter: false, bInfo: false,
            "pagingType": "full_numbers"
        });
    });
    </script>

    <script>
        $(document).ready(function () {
            (function ($) {
                $('#filter').keyup(function () {
                    var rex = new RegExp($(this).val(), 'i');
                    $('.searchable tr').hide();
                    $('.searchable tr').filter(function () {
                        return rex.test($(this).text());
                    }).show();
                })
            }(jQuery));
        });
    </script>

    <script>
        jQuery(document).ready(function($) {
            $(".clickable-issuance").click(function() {
                $('#tbl_report').load('reso/issuance_report.php');
            });

            $(".clickable-returns").click(function() {
                $('#tbl_report').load('reso/returns_report.php');
            });

            $(".clickable-warehouse").click(function() {
                $('#tbl_report').load('reso/warehouse_report.php');
            });

            $(".clickable-balance").click(function() {
                $('#tbl_report').load('reso/balance_report.php');
            });
        });
    </script>

    <script>

        function monitor(){
            $.ajax({
                url: 'ajax/monitor_dash.php',
                type: 'POST',
                data:{data: 'test'},
                dataType: 'html',
                success: function(data){
                    var vals = data.split(",");
                    $('#mon_issuance').html(vals[0]     ?   vals[0] :  '0');
                    $('#mon_return').html(vals[1]       ?   vals[1] :  '0');
                    $('#mon_warehouse').html(vals[2]    ?   vals[2] :  '0');
                    $('#mon_balance').html(vals[3]+ ',' +vals[4]+vals[5] ? vals[3] + ',' + vals[4] + ','+ vals[5] : '0');
                }
            });
        }


        // Upon loading the page, initialize the window
        window.onload = function(){
            monitor();
            checkDoc();
            unitMeasurement();
            refreshData();

            document.getElementById('assignee').value = "";
            if(document.getElementById('issuance').checked){
                category = document.getElementById('issuance').value;
            }
            console.log(category);
            
            $('#doc_save').addClass('hide');
            $('#doc_cancel').addClass('hide');
        };

    </script>

</body>

</html>
