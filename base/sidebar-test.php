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
                <a href="JavaScript:Void(0)" id="dashboard" data-href="?menu=dashboard"><span class="glyphicon glyphicon-blackboard"></span>&nbsp; Dashboard</a>
            </li>
            <li id="<?php echo ($menu == "liquidation") ? 'active' : ''; ?>">
                <a href="JavaScript:Void(0)" id="liquidation" data-href="?menu=liquidation"><span class="glyphicon glyphicon-tasks"></span>&nbsp; DR Liquidation</a>
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
        });
    </script>

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">