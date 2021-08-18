<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{title}</h3>
        <div class="box-tools pull-right">
            <button data-original-title="Collapse" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title=""><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <form action="" method="post">
        <div class="box-body to-right">
            <div class="form-group<?= (form_error('organization_name')) ? ' has-error' : ''; ?>">
                <label><?= lang('name') . ' ' . lang('zone'); ?> :</label>
                <input class="form-control" placeholder="<?= lang('name') . ' ' . lang('zone'); ?>" name="organization_name" value="<?= $organization_name; ?>" />
                <label class="control-label to-left" for="organization_name"><?= form_error('organization_name'); ?></label>
            </div>
            <input type="hidden" name="organization_parent" value="<?= $organization_parent;?>">          
            
            <div class="form-group<?= (form_error('organization_description')) ? ' has-error' : ''; ?>">
                <label><?= lang('additional') . ' ' . lang('information'); ?> :</label>
                <textarea name="organization_description" class="form-control" style="height: 300px"><?= $organization_description; ?></textarea>
                <label class="control-label to-left" for="organization_description"><?= form_error('organization_description'); ?></label>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div><!-- /.box-footer -->
    </form>
</div><!-- /. box -->