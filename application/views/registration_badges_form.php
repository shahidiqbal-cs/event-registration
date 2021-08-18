<?php
$badge_header = '';
$badge_footer = lang('signature') . ' ' . lang('chairman').': ______________________ ';
if ($this->input->post()):
    $badge_header = set_value('badge_header');
    $badge_footer = set_value('badge_footer');
endif;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"> Event Badge</h3>
                <div class="box-tools pull-right">
                    <button data-original-title="Collapse" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title=""><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <form id="form_badges" action="" method="post" class="form-horizontal">
                <div class="box-body">
                    <br>
                    <div class="form-group <?= (form_error('badge_header')) ? 'has-error' : ''; ?>">
                        <label class="col-sm-2 control-label" for="badge_header"> Badge Header</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Badge Header will show on badge top" name="badge_header" class="form-control" value="<?= $badge_header; ?>" />
                        </div>
                        <label class="col-sm-12 control-label" for="badge_header"> <i>This content will show on the top of badge (It may be event title)</i></label>
                        <label class="col-sm-offset-2 col-sm-10 control-label" for="badge_header"><?= form_error('badge_header'); ?></label>
                    </div>
                    <hr>
                    <br>
                    <div class="form-group <?= (form_error('badge_footer')) ? 'has-error' : ''; ?>">
                        <label class="col-sm-2 control-label" for="badge_footer"> Badge Footer</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Will show on badge bottom" name="badge_footer" class="form-control" value="<?= $badge_footer; ?>" />
                        </div>
                        <label class="col-sm-12 control-label" for="badge_footer"> <i>This content will show on the bottom of badge (It may be event Chairmen signature)</i></label>
                        <label class="col-sm-offset-2 col-sm-10 control-label" for="badge_footer"><?= form_error('badge_footer'); ?></label>
                    </div>
                    <hr>
                    <br>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="badge_for">Badge for</label>
                        <div class="col-sm-10">
                            <div class="col-sm-3">
                                <label class="control-label">
                                    <input type="radio" name="badge_for" class="minimal" value="all" <?= set_radio('badge_for', 'all', TRUE); ?> /> All participants
                                </label>
                            </div>
                            <div class="col-sm-3">
                                <label class="control-label">
                                    <input type="radio" name="badge_for" class="minimal" value="present" <?= set_radio('badge_for', 'present'); ?> /> Only Present
                                </label>
                            </div>
                            <div class="col-sm-6">
                                <div class="col-sm-4">
                                    <label class="control-label">
                                        <input type="radio" name="badge_for" class="minimal" value="custom" <?= set_radio('badge_for', 'custom'); ?> /> Custom
                                    </label>
                                </div>
                                <div class="col-sm-8 <?= (set_value('badge_for')!= 'custom')?'hidden':''; ?>" id="custom_ids">
                                    <input type="text" placeholder="Specify only id by comma separation" name="custom_ids" class="form-control custom_ids" value="<?= set_value('custom_ids'); ?>" />
                                </div>
                            </div>
                        </div>
                        <label class="col-sm-12 control-label" for="badge_for"> <i>This option is allowed to create badges for all or specific person(In case of custom specify id's by comma separation e.g. 34,56,77)</i></label>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-credit-card"></i> Create Badges</button>
                </div><!-- /.box-footer -->
            </form>
        </div><!-- /. box -->
    </div><!-- /.col -->
</div>