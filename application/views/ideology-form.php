<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{title}</h3>
        <div class="box-tools pull-right">
            <button data-original-title="Collapse" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title=""><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <form action="" method="post">
        <div class="box-body to-right">
            <div class="form-group<?= (form_error('ideology_status')) ? ' has-error' : ''; ?>">
                <label><?= lang('ideology_status'); ?> :</label>
                <input class="form-control" placeholder="<?= lang('ideology_status'); ?>" name="ideology_status" value="<?= $ideology_status; ?>" />
                <label class="control-label to-left" for="organization_name"><?= form_error('organization_name'); ?></label>
            </div>
            
        </div><!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div><!-- /.box-footer -->
    </form>
</div><!-- /. box -->