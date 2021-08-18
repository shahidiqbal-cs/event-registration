<div class="box box-primary">    
    <div class="box-header with-border">
        <h3 class="box-title"> Keep in mind before creating groups</h3>
        <div class="box-tools pull-right">
            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        {summary}
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{present}/{total}</h3>
                    <p>{status}</p>
                    <p>{percentage}%</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div><!-- ./col -->
        {/summary}
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{present}/{total}</h3>
                    <p>Overall</p>
                    <p>{percentage}%</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div><!-- ./col -->
    </div>
    <div class="box-footer">
        <form action="<?= site_url('registration/group_calculatation'); ?>" method="post">
            <div class="col-sm-12 form-group">
                <label class="col-sm-2 control-label" for="no_of_groups">Participant</label>
                <div class="col-sm-8">
                    <div class="form-group">
                        {summary}
                        <div class="col-sm-3">
                            <label>{status}</label>
                            <input type="checkbox" class="minimal" name="ids[]" value="{id}" checked />
                        </div>
                        {/summary}
                    </div>
                </div>
            </div>
            <div class="col-sm-12 form-group">
                <label class="col-sm-2 control-label" for="no_of_groups">No. of groups</label>
                <div class="col-sm-4">
                    <input id="group_calculator" type="number" placeholder="No of Groups" name="no_of_groups" class="form-control" min="1" max="{present}" value="1" />
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-users"></i> Create Group(s)</button>
                </div>
                <label id="group_calculator_message" class="col-sm-4 control-label hidden" for="no_of_groups">Average participant(s) in 1 group: {present}</label>
            </div>
        </form>
    </div>
</div>
