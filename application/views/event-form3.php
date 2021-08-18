<form id="event_form" class="form-horizontal" method="post" action="">
    <div class="box box-primary">
        <div class="box-header with-border">
            <!--<h3 class="box-title">Event</h3>-->
        </div>

        <div class="box-body">

            <div class="row to-right">
                <div class="col-md-6 pull-right">
                    <div class="form-group<?= (form_error('event_name')) ? ' has-error' : ''; ?>">
                        <label class="col-sm-4 control-label pull-right text-left" for="event_name"><?= lang('event_name'); ?>: </label>
                        <div class="col-sm-8 pull-right">
                            <select class="form-control to-right" name="event_name" id="event_seminar_name">
                                <?php $event_title_found = false; ?>
                                <?php foreach ($event_titles as $title): ?>
                                    <option value="<?= $title->event_title; ?>" <?= ($event_name == $title->event_title) ? 'selected' : ''; ?>><?= $title->event_title; ?></option>
                                    <?php if (!$event_title_found && $title->event_title == $event_name) $event_title_found = true; ?>
                                <?php endforeach; ?>
                                <?php if (!$event_title_found && $event_name): ?>
                                    <option value="<?= $event_name; ?>" selected ><?= $event_name; ?></option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <label class="col-sm-12 to-left" for="event_name"> <?= form_error('event_name'); ?></label>
                    </div>
                </div>
                <div class="col-md-6 pull-right">
                    <div class="form-group<?= (form_error('event_date')) ? ' has-error' : ''; ?>">
                        <label class="col-sm-4 control-label pull-right text-left" for="event_date"><?= lang('event_date'); ?>: </label>
                        <div class="col-sm-8 pull-right">
                            <div class="input-group to-left">
                                <input type="text" placeholder="<?= lang('event_date'); ?>" id="" name="event_date" class="form-control datePicker to-right" value="<?= $event_date; ?>" />
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div><!-- /.input group -->
                        </div>
                        <label id="event_date_message" class="col-sm-12 to-left" for="event_date"> <?= form_error('event_date'); ?></label>
                    </div>
                </div>
            </div>
            <div class="row to-right">
                <div class="col-md-12 pull-right">
                    <div class="form-group<?= (form_error('event_location')) ? ' has-error' : ''; ?>">
                        <label class="col-sm-2 control-label pull-right text-left" for="event_location"><?= lang('event_location'); ?>: </label>
                        <div class="col-sm-10 pull-right">
                            <div class="input-group to-left">  
                                <input type="text" placeholder="<?= lang('event_location'); ?>" name="event_location" class="form-control to-right" value="<?= $event_location; ?>" />
                                <div class="input-group-addon">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                            </div><!-- /.input group -->
                        </div>
                        <label id="event_location_message" class="col-sm-12 to-left" for="event_location"> <?= form_error('event_location'); ?></label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row to-right">
                <div class="col-sm-12 pull-right">
                    <div class="form-group">
                        <label class="col-sm-2 control-label pull-right text-left" for="organizer"><?= lang('event_arrange_by') . ' ' . lang('organization'); ?>: </label>
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-3 pull-right">
                                    <label class="control-label">
                                        <input type="radio" name="organizer" class="minimal" value="region" <?= ($organizer == 'region') ? 'checked' : ''; ?> /> <?= lang('region'); ?>
                                    </label>
                                </div>
                                <div class="col-sm-3 pull-right">
                                    <label class="control-label">
                                        <input type="radio" name="organizer" class="minimal" value="zone" <?= ($organizer == 'zone') ? 'checked' : ''; ?> /> <?= lang('zone'); ?>
                                    </label>
                                </div>
                                <div class="col-sm-3 pull-right">
                                    <label class="control-label">
                                        <input type="radio" name="organizer" class="minimal" value="city" <?= ($organizer == 'city') ? 'checked' : ''; ?> /> <?= lang('city'); ?>
                                    </label>
                                </div>
                                <div class="col-sm-3 pull-right">
                                    <label class="control-label">
                                        <input type="radio" name="organizer" class="minimal" value="halqa" <?= ($organizer == 'halqa') ? 'checked' : ''; ?> /> <?= lang('halqa'); ?>
                                    </label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-group<?= (form_error('organizer_id')) ? ' has-error' : ''; ?>">
                        <label class="col-sm-2 control-label pull-right text-left" for="organizer"><?= lang('name') . ' ' . lang('organization'); ?>: </label>
                        <div class="col-sm-10">
                            <div class="row" id="organizers">
                                <?php foreach ($list_of_organizer as $the_organizer): ?>
                                    <?php
                                    $the_organizer_id = $organizer . '_id';
                                    $the_organizer_name = $organizer . '_name';
                                    $organization_id = $the_organizer->$the_organizer_id;
                                    $organization_nmae = $the_organizer->$the_organizer_name;
                                    ?>
                                    <div class="col-sm-3 pull-right">
                                        <label class="control-label">
                                            <input type="radio" name="organizer_id" class="minimal" value="<?= $organization_id; ?>" <?= ($organizer_id == $organization_id) ? 'checked' : ''; ?> /> <?= $organization_nmae; ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <label id="organizer_id_message" class="col-sm-12 to-left" for="organizer"> <?= form_error('organizer'); ?></label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row to-right">
                <div class="col-sm-12 pull-right">
                    <div class="form-group<?= (form_error('event_type')) ? ' has-error' : ''; ?>">
                        <label class="col-sm-2 control-label pull-right text-left" for="event_type" ><?= lang('event'); ?>: </label>
                        <div class="col-sm-10">
                            <div id="event_type_row" class="row">
                                <div class="col-sm-3 pull-right">
                                    <label class="control-label">
                                        <input type="radio" name="event_type" class="minimal" value="tarbiati" <?= ($event_type == 'tarbiati') ? 'checked' : ''; ?> /> <?= lang('tarbiati').' '.lang('event'); ?>
                                    </label>
                                </div>
                                <div class="col-sm-3 pull-right">
                                    <label class="control-label">
                                        <input type="radio" name="event_type" class="minimal" value="majlis_amomi" <?= ($event_type == 'majlis_amomi') ? 'checked' : ''; ?> /> <?= lang('majlis_amomi').' '.lang('event'); ?>
                                    </label>
                                </div>
                                <div class="col-sm-3 pull-right">
                                    <label class="control-label">
                                        <input type="radio" name="event_type" class="minimal" value="dawati" <?= ($event_type == 'dawati') ? 'checked' : ''; ?> /> <?= lang('dawati').' '.lang('event'); ?>
                                    </label>
                                </div>
<!--                                <div class="col-sm-3 pull-right">
                                    <label class="control-label">
                                        <input type="radio" name="event_type" class="minimal" value="intazami" <?//= ($event_type == 'intazami') ? 'checked' : ''; ?> /> <?//= lang('intazami').' '.lang('event'); ?>
                                    </label>
                                </div>-->
                            </div>
                        </div>
                        <label id="event_type_message" class="col-sm-12 to-left" for="event_type"> <?= form_error('event_type'); ?></label>
                    </div>
                    <div class="form-group<?= (form_error('event_type_ids[]')) ? ' has-error' : ''; ?>">
                        <label class="col-sm-2 control-label pull-right text-left" for="event_type_ids[]"><?= lang('participant'); ?>: </label>
                        <div class="col-sm-10">
                            <div class="row" id="event_type_ids">
                                <?= $event_type_ids;?>
                            </div>
                        </div>
                        <label id="event_type_ids_message" class="col-sm-12 to-left" for="event_type_ids[]"> <?= form_error('event_type_ids[]'); ?></label>
                    </div>
                </div>
            </div>
            <hr>
<!--            <div class="row to-right">
                <div class="col-sm-12 pull-right">
                    <div class="form-group<?//= (form_error('ideologies[]')) ? ' has-error' : ''; ?>">
                        <label class="col-sm-2 control-label pull-right text-left" for="ideology_status" ><?//= lang('ideology_status'); ?>: </label>
                        <div class="col-sm-10">
                            <div class="row">
                                <?php // foreach ($ideologies as $ideology): ?>
                                    <div class="col-sm-3 pull-right">
                                        <input type="checkbox" class="minimal" name="ideologies[]" value="<?//= $ideology->ideology_id; ?>" <?//= (is_array($participant_by_ideology) && in_array($ideology->ideology_id, $participant_by_ideology)) ? 'checked' : ''; ?> />
                                        <label><?//= $ideology->ideology_status; ?></label>
                                    </div>
                                <?php // endforeach; ?>
                            </div>
                        </div>
                        <label id="ideology_message" class="col-sm-12 to-left" for="ideologies"> <?//= form_error('ideologies[]'); ?></label>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row to-right">
                <div class="col-sm-12 pull-right">
                    <div class="form-group<?//= (form_error('propagations[]')) ? ' has-error' : ''; ?>">
                        <label class="col-sm-2 control-label pull-right text-left" for="propagations" ><?//= lang('propagation_status'); ?>: </label>
                        <div class="col-sm-10">
                            <div class="row">
                                <?php // foreach ($propagations as $propagation): ?>
                                    <div class="col-sm-3 pull-right">
                                        <input type="checkbox" class="minimal" name="propagations[]" value="<?//= $propagation->propagation_id; ?>" <?= (is_array($participant_by_propagation) && in_array($propagation->propagation_id, $participant_by_propagation)) ? 'checked' : ''; ?>/>
                                        <label><?//= $propagation->propagation_status; ?></label>
                                    </div>
                                <?php // endforeach; ?>
                            </div>
                        </div>
                        <label id="ideology_message" class="col-sm-12 to-left" for="propagations"> <?//= form_error('propagations[]'); ?></label>
                    </div>
                </div>
            </div>
            <hr>-->
            <div class="row to-right">
                <div class="col-sm-12 pull-right"><label class="col-sm-2 control-label pull-right text-left" ><?= lang('event_for'); ?>: </label></div>
            </div>
            <div id="zone_area">
                <div class="row to-right">
                    <div class="col-sm-12 pull-right">
                        <label class="col-sm-2 control-label pull-right text-left" for="custom_zone[]" ><?= lang('zone'); ?>: </label>
                        <div class="col-sm-4 pull-right">
                            <div class="form-group<?= (form_error('zone')) ? ' has-error' : ''; ?>">
                                <div class="col-sm-6">
                                    <label class="control-label">
                                        <input type="radio" name="zone" class="minimal" value="custom" <?= ($zone_option == 'custom') ? 'checked' : ''; ?> /> <?= lang('custom'); ?>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label">
                                        <input type="radio" name="zone" class="minimal" value="all" <?= ($zone_option == 'all') ? 'checked' : ''; ?> /> <?= lang('all'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 pull-right">
                            <div id="custom_zone" class="form-group<?= ($zone_option == 'all') ? ' hidden' : ''; ?>">
                                <?php foreach ($zones as $zone): ?>
                                    <div class="col-sm-4 pull-right">
                                        <label class="control-label">
                                            <input type="checkbox" class="minimal" name="custom_zone[]" value="<?= $zone->zone_id; ?>" <?= (($zone_option == 'custom') && in_array($zone->zone_id, $cutom_zone)) ? 'checked' : ''; ?> /> <?= $zone->zone_name; ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="city_area" class="<?= ($zone_option == 'all') ? 'hidden' : ''; ?>">
                <div class="row to-right">
                    <div class="col-sm-12 pull-right">
                        <label class="col-sm-2 control-label pull-right text-left" for="city" ><?= lang('city'); ?>: </label>
                        <div class="col-sm-4 pull-right">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label class="control-label">
                                        <input type="radio" name="city" class="minimal" value="custom" <?= ($city_option == 'custom') ? 'checked' : ''; ?> /> <?= lang('custom'); ?>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label">
                                        <input type="radio" name="city" class="minimal" value="all" <?= ($city_option == 'all') ? 'checked' : ''; ?> /> <?= lang('all'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 pull-right">
                            <div id="custom_city" class="form-group<?= ($city_option == 'all') ? ' hidden' : ''; ?>">
                                <?php if ($cities): ?>
                                    <?php foreach ($cities as $city): ?>
                                        <div class="col-sm-4 pull-right">
                                            <label class="control-label">
                                                <input type="checkbox" class="minimal" name="custom_city[]" value="<?= $city->city_id; ?>" <?= (($zone_option == 'custom') && in_array($city->city_id, $cutom_city)) ? 'checked' : ''; ?>/> <?= $city->city_name; ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="halqa_area" class="<?= ($city_option == 'all') ? 'hidden' : ''; ?>">
                <div class="row to-right">
                    <div class="col-sm-12">
                        <label class="col-sm-2 control-label pull-right text-left" for="halqa" ><?= lang('halqa'); ?>: </label>
                        <div class="col-sm-4 pull-right">
                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label class="control-label">
                                        <input type="radio" name="halqa" class="minimal" value="custom" <?= ($halqa_option == 'custom') ? 'checked' : ''; ?> /> <?= lang('custom'); ?>
                                    </label>
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label">
                                        <input type="radio" name="halqa" class="minimal" value="all" <?= ($halqa_option == 'all') ? 'checked' : ''; ?> /> <?= lang('all'); ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 pull-right">
                            <div id="custom_halqa" class="form-group<?= ($halqa_option == 'all') ? ' hidden' : ''; ?>">
                                <?php if ($halqas): ?>
                                    <?php foreach ($halqas as $halqa): ?>
                                        <div class="col-sm-4 pull-right">
                                            <label class="control-label">
                                                <input type="checkbox" class="minimal" name="custom_halqa[]" value="<?= $halqa->halqa_id; ?>" <?= (($city_option == 'custom') && in_array($halqa->halqa_id, $cutom_halqa)) ? 'checked' : ''; ?>/> <?= $halqa->halqa_name; ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row to-right">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="col-sm-2 control-label pull-right text-left" for="print_header"> Print Header</label>
                        <div class="col-sm-10 pull-right">
                            <textarea class="form-control texteditor" name="print_header" style="height: 300px"><?= $print_header; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
            <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Save Event</button>
        </div>

    </div><!-- /.box -->
</form>
