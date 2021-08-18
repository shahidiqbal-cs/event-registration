<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"> Remove data and database</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="col-md-6">
            <div class="alert alert-warning">
                <i class="icon fa fa-warning"></i>Do this action if you <strong>sure</strong> what you are doing.
            </div>
        </div>
        <div class="col-md-6">
            <!--<div class="form-group">-->
            <p>This feature will remove data and database.</p>
            <p>Make sure you have backup.</p>
        </div>

    </div><!-- /.box-body -->
    <!-- form start -->
    <form role="form" method="POST" action="">
        <div class="box-footer">
            <div class="col-md-6"></div>
            <div class="col-md-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="confirm" value="1"> Are you sure want do remove?
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <input type="hidden" name="drop_db" value="drop" />
                <button type="submit" class="btn btn-primary">Yes, Please Continue</button>
            </div>
        </div>
    </form>
</div>

