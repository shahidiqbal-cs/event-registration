<?php
//echo '<pre>';
//print_r();
//exit(0);
//$event_participants_ideology = unserialize($the_event['participant_by_ideology']);
//$participants_ideology_name = array();
//foreach ($ideologies as $ideology):
//    if (in_array($ideology->ideology_id, $event_participants_ideology)):
//        array_push($participants_ideology_name, $ideology->ideology_status);
////        $participants_ideology_name .= $ideology->ideology_status . '<br>';
//    endif;
//endforeach;
?>

<?php if (!$attendance): ?>
    <div id="create_attendance_message" class="alert alert-info">
        <h4><i class="icon fa fa-info"></i> Before creating sheet make sure you have update Participant list</h4>
    </div>
<?php endif; ?>
<div class="box box-primary to-right">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $the_event['event_name']; ?></h3>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                <strong><?= lang('participant').' '.lang('organization'); ?>: </strong>&ensp; <?= $urdu_name_of_organization; ?>
                <br>
                <strong class="pull-right"><?= lang('name').' '.lang('organization'); ?> : </strong>
                <ul class="pull-right">
                    <?php
                    foreach ($participants_organizations as $key => $organization):
                        echo '<li>' . $organization . '</li>';
                    endforeach;
                    ?>
                </ul>
            </div>
            <div class="col-sm-4">
                <strong><?= lang('event_arrange_by'); ?>: </strong>&ensp; <?= $the_event['organizer_name'] . ' (' . lang($the_event['organizer']) . ')'; ?>
                <br>
                <strong><?= lang('event'); ?>: </strong>&ensp; <?= $the_event['event_type'] ; ?>
                <br>
                <strong class="pull-right"><?= lang('participant'); ?> : </strong>
                <ul class="pull-right">
                    <?= $the_event['participant_types']; ?>
                </ul>
            </div>
            <div class="col-sm-4">
                <strong><?= lang('event_date'); ?>: </strong>&ensp; <?= $the_event['event_date']; ?>
                <br>
                <strong><?= lang('event_name'); ?>: </strong>&ensp; <?= $the_event['event_name']; ?> 
                <br>
                <strong><?= lang('event_location'); ?>: </strong>&ensp; <?= $the_event['event_location']; ?>
            </div>
        </div>
    </div>
    <?php if (!$attendance): ?>
        <div class="box-footer">
            <form id="create_attendance_form" method="post">
                <input type="hidden" name="organizer_id" value="<?= $the_event['organizer_id']; ?>" />
                <input type="hidden" name="seminar_id" value="<?= $the_event['seminar_id']; ?>" />
                <input type="hidden" name="event_id" value="<?= $the_event['event_id']; ?>" />
                <input type="hidden" name="event_zone_id" value="<?= $the_event['event_zone_id']; ?>" />
                <input type="hidden" name="event_city_id" value="<?= $the_event['event_city_id']; ?>" />
                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Create Attendance Sheet</button>
            </form>  
        </div>
    <?php endif; ?>
</div><!-- /.box -->

<?php if ($attendance): ?>
    <div class="box box-primary">    
        <div class="box-header with-border">
            <h3 class="box-title"> Participant of this event</h3>
            <div class="box-tools pull-right">
                <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>


        <div class="box-body">
            <?php if ($attendance): ?>
                <table id="data_table" class="table table-bordered table-striped to-right">
                    <thead>
                        <tr>
                            <th><?= lang('name'); ?></th>
                            <th><?= lang('father_name'); ?></th>
                            <th><?= lang('ideology_status'); ?></th>
                            <th><?= lang('propagation_status'); ?></th>
                            <th><?= lang('administrative_status'); ?></th>
                            <th><?= lang('center'); ?></th>
                            <th><?= lang('attendance'); ?></th>
                            <th><?= lang('arrival_time'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attendance as $participant): ?>
                            <tr>
                                <td><?= $participant->name; ?></td>
                                <td><?= $participant->father_name; ?></td>
                                <td><?= $participant->ideology_status; ?></td>
                                <td><?= $participant->propagation_status; ?></td>
                                <td><?= $participant->administrative_status; ?></td>
                                <td><?= $participant->city_name; ?> <i class="fa fa-hand-o-left margin-r-5"></i> <?= $participant->halqa_name; ?></td>
                                <td><?= ($participant->registration_status) ? 'Present' : 'Absent'; ?></td>
                                <td class="to-left"><?= ($participant->registration_status) ? date('d-M-Y g:i a', strtotime($participant->registration_status)) : ''; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th><?= lang('name'); ?></th>
                            <th><?= lang('father_name'); ?></th>
                            <th><?= lang('ideology_status'); ?></th>
                            <th><?= lang('propagation_status'); ?></th>
                            <th><?= lang('administrative_status'); ?></th>
                            <th><?= lang('center'); ?></th>
                            <th><?= lang('attendance'); ?></th>
                            <th><?= lang('arrival_time'); ?></th>
                        </tr>
                    </tfoot>
                </table>
            <?php else: ?>
                <div class="alert alert-danger alert-dismissable">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
                    No Result found.
                </div>
            <?php endif; ?>

        </div><!-- /.box-body -->
    </div><!-- /.box -->
<?php endif; ?>