<div class="row">
    <div class="col-lg-6">
        <section class="content-header">
            <h1>
                Dashboard
            </h1>
        </section>
    </div>
    
    <!-- Open Modal transaction -->
    <div class="col-lg-6">
        <div class="pull-right" >
            <button type="submit" name="open_transact" id="open_transact" style="outline:none;" class="btn btn-success pull-right btn-md btn-block" data-toggle="modal" data-target="#modalTransaction"><span class="glyphicon glyphicon-new-window"></span>&nbsp; Open Transaction</button> 
        </div>
    </div>
</div>
<hr class="style-four">

<div class="row">            
    <div class="col-md-3 col-sm-6 col-xs-12 clickable-issuance pointer">
        <div class="info-box">
            <span class="info-box-icon bg-purple"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted">Issuance</span>
                <span class="info-box-number"><p id="mon_issuance"></p></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div><!-- /.col -->

    <div class="col-md-3 col-sm-6 col-xs-12 clickable-returns pointer">
        <div class="info-box">
            <span class="info-box-icon bg-green"><span class="glyphicon glyphicon-retweet" aria-hidden="true"></span></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted">Returns</span>
                <span class="info-box-number"><p id="mon_return"></p></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div><!-- /.col -->

    <div class="col-md-3 col-sm-7 col-xs-12 clickable-warehouse pointer">
        <div class="info-box">
            <span class="info-box-icon bg-red"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted">Warehouse Delivery</span>
                <span class="info-box-number"><p id="mon_warehouse"></p></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div><!-- /.col -->
    
    <div class="col-md-3 col-sm-6 col-xs-12 clickable-balance pointer">
        <div class="info-box">
            <span class="info-box-icon bg-orange"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span></span>
            <div class="info-box-content">
                <span class="info-box-text text-muted">Begining Balance</span>
                <span class="info-box-number"><p id="mon_balance"></p></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div><!-- /.col -->
</div><!-- /.row -->
<hr class="style-four">
</br>

<div id="tbl_report" style="height: 360px;">
</div>