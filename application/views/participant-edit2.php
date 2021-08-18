<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Participant Details</h3>
    </div>
    <form class="form-horizontal" method="post" action="http://localhost/ci_shades/admin/paypal_setting">
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
                                <input type="text" placeholder="Father Name" name="father_name" class="form-control to-right">
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
                    <div class="form-group">
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input type="text" placeholder="Name" name="name" class="form-control to-right" >
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                            </div><!-- /.input group -->
                        </div>
                        <label class="col-sm-3 control-label" for="name"> Name</label>
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
                                <input type="text" placeholder="Number" name="participant_no" class="form-control" data-inputmask='"mask": "9999-9999999"' data-mask>
                            </div><!-- /.input group -->
                        </div>
                        <label class="col-sm-3 control-label" for="participant_no">Number</label>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div class="form-group">
                        <div class="col-sm-9">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-envelope-o"></i>
                                </div>
                                <input type="email" placeholder="Email" name="participant_email" class="form-control" >
                            </div><!-- /.input group -->
                        </div>
                        <label class="col-sm-3 control-label" for="participant_email">Email</label>
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
                                <input type="text" placeholder="CNIC" name="participant_cnic" class="form-control" data-inputmask='"mask": "99999-9999999-9"' data-mask>
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
                                <input type="text" placeholder="Temporary Address" name="temp_address" class="form-control to-right">
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
                                <input type="text" placeholder="Permanent Address" name="permanent_address" class="form-control to-right">
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
                                    <option value="<?= $ideology->ideology_id; ?>"><?= $ideology->ideology_status; ?></option>
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
                                    <option value="<?= $propagation->propagation_id; ?>"><?= $propagation->propagation_status; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <label for="APISubject" class="col-sm-2 control-label">Propagation</label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-9 to-right">
                            <input type="text" class="form-control" name="administrative_status" placeholder="Administrative Status" />
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
                            <select class="form-control" name="" id="city_organization">
                                <?php foreach ($cites as $city): ?>
                                    <option value="<?= $city->city_id; ?>"><?= $city->city_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <label class="col-sm-2 control-label">City Organization</label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-9 to-right">
                            <select class="form-control"  id="halqa_organization">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <label class="col-sm-2 control-label">Halqa Organization</label>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-1"></div>
                        <div class="col-sm-9 to-right">
                            <select class="form-control" name="unit_id">
                                <option value="">Select</option>
                            </select>
                        </div>
                        <label for="unit_id" class="col-sm-2 control-label">Unit Organization</label>
                    </div>
                </div>
                <!--</div>-->
            </div>
        </div><!-- /.box-body -->
    </form>
    <div class="box-footer">
        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save Participant</button>
    </div>
</div><!-- /.box -->

