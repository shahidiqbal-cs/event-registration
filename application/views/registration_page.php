<div class="box box-primary">    
    <div class="box-header with-border">
        <h3 class="box-title"> Participant of this event</h3>
        <div class="box-tools pull-right">
            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <!--        <form action="" method="get">
                    
                </form>
                <hr>-->
        <?php if ($attendance): ?>
            <table id="data_table" class="table table-bordered table-striped to-right">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>ID</th>
                        <th><?= lang('name'); ?></th>
                        <th><?= lang('father_name'); ?></th>
                        <th><?= lang('ideology_status'); ?></th>
                        <th><?= lang('propagation_status'); ?></th>
                        <th><?= lang('majlis_amomi'); ?></th>
<!--                        <th><?//= lang('administrative_status'); ?></th>-->
                        <th><?= lang('center'); ?></th>
                        <th style="width: 45px;"><?= lang('leave'); ?></th>
                        <th style="width: 45px;"><?= lang('attendance'); ?></th>
                        <th><?= lang('arrival_time'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($attendance as $participant): ?>
                        <?php
                        $registration_id = $participant->registration_id;
                        $on_leave = $participant->on_leave;
                        $present = ($participant->registration_status) ? true : false;
                        ?>
                        <tr id="registration_row_<?= $registration_id; ?>">
                            <td>
                                <a href="<?= site_url('registration/delete/' . $participant->registration_id) . '?url=' . current_url(); ?>" title="Remove" data-confirm="Are you sure you want to remove from registration?"><i class="fa fa-trash"></i></a> &ensp;
                                <a title="Edit sharek" target="_blank" href="<?= site_url('participant/update/' . $participant->participant_id); ?>"><i class="fa fa-edit"></i></a>&ensp;
                            </td>
                            <td><?= $participant->participant_id; ?></td>
                            <td><?= $participant->name; ?></td>
                            <td><?= $participant->father_name; ?></td>
                            <td><?= $participant->ideology_status; ?></td>
                            <td><?= $participant->propagation_status; ?></td>
                            <td><?= $participant->majlis_amomi_status; ?></td>
                            <!--<td><?//= $participant->administrative_status; ?></td>-->
                            <td><?= $participant->zone_name; ?> <i class="fa fa-hand-o-left margin-r-5"></i> <?= $participant->city_name; ?></td>
                            <td>
                                <div class="btn-group" data-toggle="btn-toggle" >
                                    <button type="button" class="btn btn-default btn-leave btn-sm<?= (!$on_leave) ? ' active' : ''; ?>" onclick="update_registration_leave(<?= $registration_id; ?>, 1)" <?= ($on_leave) ? ' disabled' : ''; ?>>
                                        <i class="fa fa-check text-green"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-leave btn-sm<?= ($on_leave) ? ' active' : ''; ?>" onclick="update_registration_leave(<?= $registration_id; ?>, 0)" <?= (!$on_leave) ? ' disabled' : ''; ?>>
                                        <i class="fa fa-close text-red"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" data-toggle="btn-toggle" >
                                    <button type="button" class="btn btn-default btn-attendance btn-sm<?= (!$present) ? ' active' : ''; ?>" onclick="update_registration(<?= $registration_id; ?>, 1)" <?= ($present or $on_leave) ? ' disabled' : ''; ?>>
                                        <i class="fa fa-check text-green"></i>
                                    </button>
                                    <button type="button" class="btn btn-default btn-attendance btn-sm<?= ($present) ? ' active' : ''; ?>" onclick="update_registration(<?= $registration_id; ?>, 0)" <?= (!$present or $on_leave) ? ' disabled' : ''; ?>>
                                        <i class="fa fa-close text-red"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="to-left time"><?= ($on_leave) ? 'On leave' : (($participant->registration_status) ? date('d-M-Y g:i a', strtotime($participant->registration_time)) : ''); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Action</th>
                        <th>ID</th>
                        <th><?= lang('name'); ?></th>
                        <th><?= lang('father_name'); ?></th>
                        <th><?= lang('ideology_status'); ?></th>
                        <th><?= lang('propagation_status'); ?></th>
                        <th><?= lang('majlis_amomi'); ?></th>
                        <!--<th><?//= lang('administrative_status'); ?></th>-->
                        <th><?= lang('center'); ?></th>
                        <th><?= lang('leave'); ?></th>
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