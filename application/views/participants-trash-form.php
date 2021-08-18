<form class="form-horizontal" method="post" action="">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Trash (<?= $participant['name']; ?>)</h3>
        </div>

        <div class="box-body">
            <div class="row to-right">
                <div class="col-sm-12">
                    <div class="col-sm-3 pull-right"><?= lang('name') . ': ' . $participant['name']; ?></div>
                    <div class="col-sm-3 pull-right"><?= lang('father_name') . ': ' . $participant['father_name']; ?></div>
                    <div class="col-sm-3 pull-right"><?= lang('contact_number') . ': ' . $participant['participant_no']; ?></div>
                    <div class="col-sm-3 pull-right"><?= lang('email') . ': ' . $participant['participant_email']; ?></div>
                    <div class="col-sm-3 pull-right"><?= lang('ideology_status') . ': ' . $participant['ideology_status']; ?></div>
                    <div class="col-sm-3 pull-right"><?= lang('propagation_status') . ': ' . $participant['propagation_status']; ?></div>
                    <div class="col-sm-3 pull-right"><?= lang('majlis_amomi') . ': ' . $participant['majlis_amomi_status']; ?></div>
                    <div class="col-sm-3 pull-right"><?= lang('branch') . ': ' . $participant['zone_name'] . ' <i class="fa fa-hand-o-left margin-r-5"></i> ' . $participant['city_name'] . ' <i class="fa fa-hand-o-left margin-r-5"></i> ' . $participant['halqa_name']; ?></div>
                </div>
            </div>
            <hr>
            <div class="row to-right">
                <div class="col-sm-12 pull-right">
                    <div class="form-group<?= (form_error('participant_status')) ? ' has-error' : ''; ?>">
                        <label class="col-sm-2 control-label pull-right text-left" for="participant_status"><?= lang('trash'); ?>: </label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-3 pull-right">
                                    <label class="control-label">
                                        <input type="radio" name="participant_status" class="minimal" value="0" <?= (!$participant['participant_status']) ? 'checked' : ''; ?> /> <?= lang('keep_in_trash'); ?>
                                    </label>
                                </div>
                                <div class="col-sm-3 pull-right">
                                    <label class="control-label">
                                        <input type="radio" name="participant_status" class="minimal" value="1" <?= ($participant['participant_status']) ? 'checked' : ''; ?> /> <?= lang('move_to_record'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row to-right">
                <div class="col-sm-12 pull-right">
                    <div class="form-group<?= (form_error('participant_status_text')) ? ' has-error' : ''; ?>">
                        <label class="col-sm-2 control-label pull-right text-left" for="participant_status_text"><?= lang('status') ?>: </label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-3 pull-right">
                                    <label class="control-label">
                                        <input type="radio" name="participant_status_text" class="minimal" value="drop" <?= ($participant['participant_status_text'] == 'drop') ? 'checked' : ''; ?> /> <?= lang('drop') ?>
                                    </label>
                                </div>
                                <div class="col-sm-3 pull-right">
                                    <label class="control-label">
                                        <input type="radio" name="participant_status_text" class="minimal" value="shift" <?= ($participant['participant_status_text'] == 'shift') ? 'checked' : ''; ?>/> <?= lang('shift') ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="to-right">
                <div class="col-sm-12 pull-right">
                    <div class="form-group">
                        <label class="col-sm-2 control-label pull-right text-left" for="comments"><?= lang('comment') ?>: </label>
                        <div class="col-sm-10">
                            <textarea class="form-control to-right" name="comments" style="height: 100px"><?= $participant['comments']; ?></textarea>                           
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.box-body -->


        <div class="box-footer">
            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save Data</button>
        </div>

    </div><!-- /.box -->
</form>
