<?php 

// Get the User Position
$data = Dynaset::load("SELECT Position From Users Where DistinctID = {$found_user->DistinctID}");
$row = mssql_fetch_assoc($data);

$name = strtolower($found_user->FirstName." ".$found_user->LastName);
$position = strtolower($row['Position']);
?>
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <div class="user-panel">
            <div class="image pull-left">
                <a href=""><img src="<?php echo "../../public/Photos/".$found_user->DistinctID.".png";?>" class="img-circle" alt="User Image"></a>
            </div>
            <div class="slogan pull-right">
                <h3 class="pull-left text-capitalize"><?php echo ucwords($name); ?></h3>
                <br>
                <h5 class="pull-left text-capitalize"><?php echo ucwords($position);?></h5>
            </div>
        </div>
        
        <ul class="sidebar-nav">
            <li>
                <h3>NAVIGATION</h3>
            </li>
            <li id="<?php echo ($menu == "dashboard") ? 'active' : ''; ?>">
                <a href="#" id="dashboard" data-href="?menu=dashboard"><span class="glyphicon glyphicon-blackboard"></span>&nbsp; Dashboard</a>
            </li>
            <li id="<?php echo ($menu == "liquidation") ? 'active' : ''; ?>">
                <a href="#" id="liquidation" data-href="?menu=liquidation"><span class="glyphicon glyphicon-tasks"></span>&nbsp; DR Liquidation</a>
            </li>
            <li id="<?php echo ($menu == "warehouse_inventory") ? 'active' : ''; ?>">
                <a href="#" id="warehouse_inventory" data-href="?menu=warehouse_inventory"><span class="glyphicon glyphicon-home"></span>&nbsp; Warehouse Inventory Summary</a>
            </li>
            <li id="<?php echo ($menu == "detailed_inventory") ? 'active' : ''; ?>">
                <a href="#" id="detailed_inventory" data-href="?menu=detailed_inventory"><span class="glyphicon glyphicon-th-list"></span>&nbsp; Inventory Detailed Per Farm</a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <script>
        jQuery(document).ready(function($){
            $('#liquidation').click(function(){
                window.document.location = $(this).data("href");
            });

            $('#dashboard').click(function(){
                window.document.location = $(this).data("href");
            });

            $('#warehouse_inventory').click(function(){
                window.document.location = $(this).data("href");
            });

            $('#detailed_inventory').click(function(){
                window.document.location = $(this).data("href");
            });
        });
    </script>

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">