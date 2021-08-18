<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"> Export Data</h3>
                <div class="box-tools pull-right">
                    <button data-original-title="Collapse" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title=""><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <form id="export_participants" action="" method="post" class="form-horizontal">
                <div class="box-body to-right">
                    <div class="row">
                        <div class="col-sm-12"><h4>Export Columns</h4></div>

                        <div class="col-sm-12">
                            <div class="form-group move-list">

                                <div class="col-sm-2 pull-right">
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <input type="checkbox" class="minimal" name="exportcolumns[]" value="participant.participant_id" />
                                    <label>ID</label>
                                </div>
                                <div class="col-sm-2 pull-right">
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <input type="checkbox" class="minimal" name="exportcolumns[]" value="participant.name" checked />
                                    <label><?= lang('name'); ?></label>
                                </div>
                                <div class="col-sm-2 pull-right">
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <input type="checkbox" class="minimal" name="exportcolumns[]" value="participant.father_name" checked />
                                    <label><?= lang('father_name'); ?></label>
                                </div>
                                <div class="col-sm-2 pull-right">
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <input type="checkbox" class="minimal" name="exportcolumns[]" value="ideology.ideology_status" checked />
                                    <label><?= lang('ideology_status'); ?></label>
                                </div>
                                <div class="col-sm-2 pull-right">
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <input type="checkbox" class="minimal" name="exportcolumns[]" value="propagation.propagation_status" />
                                    <label><?= lang('propagation_status'); ?></label>
                                </div>
                                <div class="col-sm-2 pull-right">
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <input type="checkbox" class="minimal" name="exportcolumns[]" value="majlis_amomi.majlis_amomi_status" />
                                    <label><?= lang('majlis_amomi'); ?></label>
                                </div>
                                <div class="col-sm-2 pull-right">
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <input type="checkbox" class="minimal" name="exportcolumns[]" value="zone.zone_name" checked />
                                    <label><?= lang('zone'); ?></label>
                                </div>
                                <div class="col-sm-2 pull-right">
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <input type="checkbox" class="minimal" name="exportcolumns[]" value="city.city_name" checked />
                                    <label><?= lang('city'); ?></label>
                                </div>
                                <div class="col-sm-2 pull-right">
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <input type="checkbox" class="minimal" name="exportcolumns[]" value="halqa.halqa_name" checked />
                                    <label><?= lang('halqa'); ?></label>
                                </div>
                                <div class="col-sm-2 pull-right">
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <input type="checkbox" class="minimal" name="exportcolumns[]" value="participant.participant_no" />
                                    <label><?= lang('contact_number'); ?></label>
                                </div>
                                <div class="col-sm-2 pull-right">
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <input type="checkbox" class="minimal" name="exportcolumns[]" value="participant.participant_email" />
                                    <label><?= lang('email'); ?></label>
                                </div>
                                <div class="col-sm-2 pull-right">
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <input type="checkbox" class="minimal" name="exportcolumns[]" value="participant.participant_cnic" />
                                    <label><?= lang('cnic'); ?></label>
                                </div>
                                <div class="col-sm-2 pull-right">
                                    <span class="handle">
                                        <i class="fa fa-ellipsis-v"></i>
                                        <i class="fa fa-ellipsis-v"></i>
                                    </span>
                                    <input type="checkbox" class="minimal" name="exportcolumns[]" value="participant.blood_group" />
                                    <label><?= lang('blood').' '.lang('group'); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12"><h4><?= lang('ideology_status'); ?></h4></div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <?php foreach ($ideologies as $ideology): ?>
                                    <div class="col-sm-2 pull-right">
                                        <input type="checkbox" class="minimal" name="ideologies[]" value="<?= $ideology->ideology_id; ?>" checked />
                                        <label><?= $ideology->ideology_status; ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12"><h4><?= lang('propagation_status'); ?></h4></div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <?php foreach ($propagations as $propagation): ?>
                                    <div class="col-sm-2 pull-right">
                                        <input type="checkbox" class="minimal" name="propagation[]" value="<?= $propagation->propagation_id; ?>" checked />
                                        <label><?= $propagation->propagation_status; ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div id="zone_area">
                        <div class="row">
                            <div class="col-sm-12"><h4><?= lang('zone'); ?></h4></div>
                            <div class="col-sm-12">

                                <div class="col-sm-8">
                                    <div id="custom_zone" class="form-group hidden">
                                        <?php foreach ($zones as $zone): ?>
                                            <div class="col-sm-4 pull-right">
                                                <label class="control-label">
                                                    <input type="checkbox" class="minimal" name="custom_zone[]" value="<?= $zone->zone_id; ?>" /> <?= $zone->zone_name; ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                <input type="radio" name="zone" class="minimal" value="custom" <?= set_radio('zone', 'custom'); ?> /> <?= lang('custom'); ?>
                                            </label>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="control-label">
                                                <input type="radio" name="zone" class="minimal" value="all" <?= set_radio('zone', 'all', TRUE); ?> /> <?= lang('all'); ?>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div id="city_area" class="hidden">
                        <div class="row">
                            <div class="col-sm-12"><h4><?= lang('city'); ?></h4></div>
                            <div class="col-sm-12">
                                <div class="col-sm-8">
                                    <div id="custom_city" class="form-group hidden">

                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label">
                                        <input type="radio" name="city" class="minimal" value="custom" <?= set_radio('city', 'custom'); ?> /> <?= lang('custom'); ?>
                                    </label>

                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label">
                                        <input type="radio" name="city" class="minimal" value="all" <?= set_radio('city', 'all', TRUE); ?> /> <?= lang('all'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div id="halqa_area" class="hidden">
                        <div class="row">
                            <div class="col-sm-12"><h4><?= lang('halqa'); ?></h4></div>
                            <div class="col-sm-12">
                                <div class="col-sm-8">
                                    <div id="custom_halqa" class="form-group hidden">

                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label">
                                        <input type="radio" name="halqa" class="minimal" value="custom" <?= set_radio('halqa', 'custom'); ?> /> <?= lang('custom'); ?>
                                    </label>

                                </div>
                                <div class="col-sm-2">
                                    <label class="control-label">
                                        <input type="radio" name="halqa" class="minimal" value="all" <?= set_radio('halqa', 'all', TRUE); ?> /> <?= lang('all'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-download"></i> Download Excel</button>
                </div><!-- /.box-footer -->
            </form>
        </div><!-- /. box -->
    </div><!-- /.col -->
</div>