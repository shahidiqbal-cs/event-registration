<?php
//$action_url = site_url('tfw/participant_new');
//if ($participant_id):
//    $action_url = site_url('tfw/participant_action/edit/' . $participant_id);
//endif;
?>
<!--<form id="participant_form" class="form-horizontal" method="post" action="<? //= $action_url;        ?>">-->
<form id="participant_form" class="form-horizontal" method="post" action="">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Participant Details</h3>
        </div>

        <div class="box-body">
            <div class="col-md-12 bg-green">
                <div class="form-group text-center">
                    <label class="col-sm-12"><h3><?= lang('personal') . ' ' . lang('information'); ?></h3></label>
                </div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" placeholder="<?= lang('father_name'); ?>" name="father_name" class="form-control to-right" value="<?= $fname; ?>" />
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div><!-- /.input group -->
                            </div>
                            <label class="col-sm-3 control-label text-left" for="father_name"> :<?= lang('father_name'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <div class="form-group<?= (form_error('name')) ? ' has-error' : ''; ?>">
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <input type="text" placeholder="<?= lang('name'); ?>" name="name" class="form-control to-right" value="<?= $name; ?>" />
                                    <div class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div><!-- /.input group -->
                            </div>
                            <label class="col-sm-3 control-label text-left" for="name"> :<?= lang('name'); ?></label>
                            <label class="col-sm-12" for="name"> <?= form_error('name'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <input type="text" placeholder="<?= lang('contact_number'); ?>" name="participant_no" class="form-control" value="<?= $participant_no; ?>" data-inputmask='"mask": "9999-9999999"' data-mask />
                                </div><!-- /.input group -->
                            </div>
                            <label class="col-sm-3 control-label text-left" for="participant_no"> :<?= lang('contact_number'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <div class="form-group<?= (form_error('participant_email')) ? ' has-error' : ''; ?>">
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope-o"></i>
                                    </div>
                                    <input type="email" placeholder="Email" name="participant_email" class="form-control" value="<?= $email; ?>" />
                                </div><!-- /.input group -->
                            </div>
                            <label class="col-sm-3 control-label text-left" for="participant_email"> :<?= lang('email'); ?></label>
                            <label class="col-sm-12" for="participant_email"> <?= form_error('participant_email'); ?></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <div class="col-sm-9">
                                <select name="blood_group" class="form-control">
                                    <option value=""><?= lang('unknown'); ?></option>
                                    <option value="A+" <?= ($blood_group == 'A+') ? 'selected' : ''; ?>>A+</option>
                                    <option value="A-" <?= ($blood_group == 'A-') ? 'selected' : ''; ?>>A-</option>
                                    <option value="B+" <?= ($blood_group == 'B+') ? 'selected' : ''; ?>>B+</option>
                                    <option value="B-" <?= ($blood_group == 'B-') ? 'selected' : ''; ?>>B-</option>
                                    <option value="AB+" <?= ($blood_group == 'AB+') ? 'selected' : ''; ?>>AB+</option>
                                    <option value="AB-" <?= ($blood_group == 'AB-') ? 'selected' : ''; ?>>AB-</option>
                                    <option value="O+" <?= ($blood_group == 'O+') ? 'selected' : ''; ?>>O+</option>
                                    <option value="O-" <?= ($blood_group == 'O-') ? 'selected' : ''; ?>>O-</option>
                                </select>
                            </div>
                            <label class="col-sm-3 control-label text-left" for="blood_group"> :<?= lang('blood') . ' ' . lang('group'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <div class="col-sm-9">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-credit-card"></i>
                                    </div>
                                    <input type="text" placeholder="CNIC" name="participant_cnic" class="form-control" data-inputmask='"mask": "99999-9999999-9"' data-mask value="<?= $cnic; ?>" />
                                </div><!-- /.input group -->
                            </div>
                            <label class="col-sm-3 control-label text-left" for="participant_cnic"> :<?= lang('cnic'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="col-md-12">
                <div class="row to-right">
                    <!--<div class="col-md-12">-->
                    <div class="col-sm-6 bg-aqua">
                        <div class="form-group text-center">
                            <label class="col-sm-12"><h3><?= lang('organizational') . ' ' . lang('status'); ?></h3></label>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-8 to-right">
                                <select class="form-control" name="ideology_id">
                                    <?php foreach ($ideologies as $ideology): ?>
                                        <option value="<?= $ideology->ideology_id; ?>" <?= ($ideology_id == $ideology->ideology_id) ? 'selected' : ''; ?>><?= $ideology->ideology_status; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <label for="ideology_id" class="col-sm-3 control-label text-left"><?= lang('ideology_status'); ?>: </label>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-8 to-right">
                                <select class="form-control" name="propagation_id">
                                    <?php foreach ($propagations as $propagation): ?>
                                        <option value="<?= $propagation->propagation_id; ?>" <?= ($propagation_id == $propagation->propagation_id) ? 'selected' : ''; ?>><?= $propagation->propagation_status; ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                            <label for="propagation_status" class="col-sm-3 control-label text-left"><?= lang('propagation_status'); ?>: </label>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-8 to-right">
                                <select class="form-control" name="majlis_amomi_id">
                                    <option value="0" <?= ($majlis_amomi_id == 0) ? 'selected' : ''; ?>><?= lang('no_one'); ?></option>
                                    <?php foreach ($majlis_amomis as $majlis_amomi): ?>
                                        <option value="<?= $majlis_amomi->majlis_amomi_id; ?>" <?= ($majlis_amomi_id == $majlis_amomi->majlis_amomi_id) ? 'selected' : ''; ?>><?= $majlis_amomi->majlis_amomi_status; ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                            <label for="majlis_amomi_id" class="col-sm-3 control-label text-left"><?= lang('majlis_amomi'); ?>: </label>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-8 to-right">
                                <input type="text" class="form-control" name="administrative_status" placeholder="<?= lang('administrative_status'); ?>" value="<?= $administrative_status; ?>" />
                            </div>
                            <label for="administrative_status" class="col-sm-3 control-label text-left"><?= lang('administrative_status'); ?>: </label>
                        </div>
                    </div>
                    <div class="col-sm-6 bg-light-blue">
                        <div class="form-group text-center">
                            <label class="col-sm-12"><h3><?= lang('organizations'); ?></h3></label>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-8 to-right">
                                <select class="form-control" name="zone_id" id="zone_organization">
                                    <?php foreach ($zones as $zone): ?>
                                        <option value="<?= $zone->zone_id; ?>" <?= ($zone_id == $zone->zone_id) ? 'selected' : ''; ?>><?= $zone->zone_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <label class="col-sm-3 control-label text-left"><?= lang('zone'); ?>: </label>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-8 to-right">
                                <select class="form-control" name="city_id" id="city_organization">
                                    <?php foreach ($cites as $city): ?>
                                        <option value="<?= $city->city_id; ?>" <?= ($city_id == $city->city_id) ? 'selected' : ''; ?>><?= $city->city_name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <label class="col-sm-3 control-label text-left"><?= lang('city'); ?>: </label>
                        </div>
                    </div>
                    <?php if ($this->session->userdata('active_event') && !$participant_id): ?>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="col-sm-1"></div>
                                <div class="col-sm-8 to-right">
                                    <label class=" col-sm-6 control-label">
                                        <input type="radio" name="add_to_current_event" class="minimal" value="0" /> <?= lang('no'); ?>
                                    </label>
                                    <label class="col-sm-6 control-label">
                                        <input type="radio" name="add_to_current_event" class="minimal" value="1" checked /> <?= lang('yes'); ?>
                                    </label>
                                </div>
                                <label class="col-sm-3 control-label text-left"><?= lang('add_to_current_event'); ?>: </label>
                            </div>


                        </div>
                    <?php endif; ?>
                    <!--</div>-->
                </div>
            </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save Participant</button>
        </div>

    </div><!-- /.box -->
</form>
