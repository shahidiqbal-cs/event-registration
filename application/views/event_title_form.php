<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{title}</h3>
        <div class="box-tools pull-right">
            <button data-original-title="Collapse" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title=""><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <form action="" method="post">
        <div class="box-body to-right">
            <div class="form-group<?= (form_error('title')) ? ' has-error' : ''; ?>">
                <label><?= lang('name'); ?> :</label>
                <input class="form-control" placeholder="<?= lang('name') ; ?>" name="title" value="<?= $event_title; ?>" />
                <label class="control-label to-left" for="title"><?= form_error('title'); ?></label>
            </div>
            
            <div class="form-group">
                <label><?= lang('additional') . ' ' . lang('information'); ?> :</label>
                <textarea name="title_description" class="form-control" style="height: 300px"><?= $title_description; ?></textarea>
                <label class="control-label to-left" for="title_description"></label>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
        </div><!-- /.box-footer -->
    </form>
</div><!-- /. box -->