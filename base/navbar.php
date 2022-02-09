<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
        
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand pull-left " href="#" id="menu-toggle" style="outline:none;"><span class="glyphicon glyphicon-menu-hamburger soft-white chevron"></span></a>
                <a class="navbar-brand pull-left" style="outline:none;" id='space' href="#">Asset Management</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>&nbsp; <?php echo ucwords(strtolower($found_user->FirstName)); ?> <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <!-- <li><a href="#">Profile</a></li> -->
                    <!-- <li><a href="#">Settings</a></li> -->
                    <li role="separator" class="divider"></li>
                    <li><a href="https://ulr2.universalleaf.com.ph/EO2021v4/public/index.php"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a></li>
                  </ul>
                </li>
              </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
