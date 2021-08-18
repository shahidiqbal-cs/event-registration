<?php
$name = '';
$fname = '';
$email = '';
$participant_no = '';
$cnic = '';
$temp_address = '';
$permanent_address = '';
$ideology_id = '';
$propagation_id = '';
$administrative_status = '';
$city_id = '';
$halqa_id = '';
$unit_id = '';
if ($this->input->post()):
    $name = set_value('name');
    $fname = set_value('father_name');
    $email = set_value('participant_email');
    $participant_no = set_value('participant_no');
    $cnic = set_value('participant_cnic');
    $temp_address = set_value('temp_address');
    $permanent_address = set_value('permanent_address');
    $ideology_id = set_value('ideology_id');
    $propagation_id = set_value('propagation_id');
    $administrative_status = set_value('administrative_status');
    $city_id = set_value('city_id');
    $halqa_id = set_value('halqa_id');
    $unit_id = set_value('unit_id');
endif;
?>
<form id="participant_form" class="form-horizontal" method="post" action="<?= site_url('tfw/participant_new'); ?>">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Participant Details</h3>
        </div>

        <div class="box-body">
            <div class="form-group">
                <label class="col-sm-12"><h3>Personal Details</h3></label>
            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div class="form-group">
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" placeholder="Father Name" name="father_name" class="form-control to-right" value="<?= $fname; ?>" />
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                            </div><!-- /.input group -->
                        </div>
                        <label class="col-sm-3 control-label" for="father_name">Father Name</label>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div class="form-group<?= (form_error('name')) ? ' has-error' : ''; ?>">
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" placeholder="Name" name="name" class="form-control to-right" value="<?= $name; ?>" />
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                            </div><!-- /.input group -->
                        </div>
                        <label class="col-sm-3 control-label" for="name"> Name</label>
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
                                <input type="text" placeholder="Number" name="participant_no" class="form-control" value="<?= $participant_no; ?>" data-inputmask='"mask": "9999-9999999"' data-mask />
                            </div><!-- /.input group -->
                        </div>
                        <label class="col-sm-3 control-label" for="participant_no">Number</label>
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
                        <label class="col-sm-3 control-label" for="participant_email">Email</label>
                        <label class="col-sm-12" for="participant_email"> <?= form_error('participant_email'); ?></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-5">

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
                        <label class="col-sm-3 control-label" for="participant_cnic">CNIC</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-11">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" placeholder="Temporary Address" name="temp_address" class="form-control to-right" value="<?= $temp_address; ?>" />
                                <div class="input-group-addon">
                                    <i class="fa fa-home"></i>
                                </div>
                            </div><!-- /.input group -->
                        </div>
                        <label class="col-sm-2 control-label" for="temp_address">Temporary Address</label>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-11">
                    <div class="form-group">
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" placeholder="Permanent Address" name="permanent_address" class="form-control to-right" value="<?= $permanent_address; ?>" />
                                <div class="input-group-addon">
                                    <i class="fa fa-home"></i>
                                </div>
                            </div><!-- /.input group -->
                        </div>
                        <label class="col-sm-2 control-label" for="permanent_address">Permanent Address</label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row to-right">
                <!--<div class="col-md-12">-->
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-12"><h3>Organizational Statuses</h3></label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-9 to-right">
                            <select class="form-control" name="ideology_id">
                                <?php foreach ($ideologies as $ideology): ?>
                                    <option value="<?= $ideology->ideology_id; ?>" <?= ($ideology_id==$ideology->ideology_id) ? 'selected' : ''; ?>><?= $ideology->ideology_status; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <label for="APISubject" class="col-sm-2 control-label">Ideology</label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-9 to-right">
                            <select class="form-control" name="propagation_id">
                                <?php foreach ($propagations as $propagation): ?>
                                    <option value="<?= $propagation->propagation_id; ?>" <?= ($propagation_id==$propagation->propagation_id) ? 'selected' : ''; ?>><?= $propagation->propagation_status; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <label for="APISubject" class="col-sm-2 control-label">Propagation</label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-9 to-right">
                            <input type="text" class="form-control" name="administrative_status" placeholder="Administrative Status" value="<?= $administrative_status;?>" />
                        </div>
                        <label for="administrative_status" class="col-sm-2 control-label">Administrative Status</label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-12"><h3>Organizational Hierarchy</h3></label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-9 to-right">
                            <select class="form-control" name="city_id" id="city_organization">
                                <?php foreach ($cites as $city): ?>
                                    <option value="<?= $city->city_id; ?>" <?= ($city_id==$city->city_id) ? 'selected' : ''; ?>><?= $city->city_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <label class="col-sm-2 control-label">City Organization</label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-9 to-right">
                            <select class="form-control" name="halqa_id" id="halqa_organization">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <label class="col-sm-2 control-label">Halqa Organization</label>
                    </div>
                    <div class="form-group<?= (form_error('unit_id')) ? ' has-error' : ''; ?>">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-9 to-right">
                            <select class="form-control" name="unit_id" id="unit_organization">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <label for="unit_id" class="col-sm-2 control-label">Unit Organization</label>
                        <label class="col-sm-9 col-sm-offset-1" for="unit_id"> <?= form_error('unit_id'); ?></label>
                    </div>
                </div>
                <!--</div>-->
            </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save Participant</button>
        </div>

    </div><!-- /.box -->
</form>
