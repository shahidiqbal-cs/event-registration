<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">{title}</h3>
        <div class="box-tools pull-right">
            <button data-original-title="Collapse" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title=""><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <form action="" method="post">
        <div class="box-body">
            <div class="form-group<?= (form_error('feedbacker_name')) ? ' has-error' : ''; ?>">
                <label>Your's Name :</label>
                <input class="form-control" placeholder="Your's Name" name="feedbacker_name" value="<?= $feedbacker_name;?>" />
                <label class="control-label" for="feedbacker_name"><?= form_error('feedbacker_name'); ?></label>
            </div>
            <div class="form-group<?= (form_error('feedback_type')) ? ' has-error' : ''; ?>">
                <label>Feedback Type :</label>
                <select class="form-control" name="feedback_type">
                    <option value="Bug" <?= ($feedback_type == 'Bug')?'selected':'';?>>Bug</option>
                    <option value="Suggestion" <?= ($feedback_type == 'Suggestion')?'selected':'';?>>Suggestion</option>
                    <option value="Other" <?= ($feedback_type == 'Other')?'selected':'';?>>Other</option>
                </select>
                <label class="control-label" for="title"><?= form_error('feedback_type'); ?></label>
            </div>
            <div class="form-group<?= (form_error('feedback')) ? ' has-error' : ''; ?>">
                <label>Your's feedback :</label>
                <textarea name="feedback" class="form-control" style="height: 150px"><?= $feedback;?></textarea>
                <label class="control-label" for="feedback"><?= form_error('feedback'); ?></label>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Post</button>
        </div><!-- /.box-footer -->
    </form>
</div><!-- /. box -->