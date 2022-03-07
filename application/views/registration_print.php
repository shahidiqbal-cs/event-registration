<?php
//echo '<pre>';
//print_r($event);
//exit(0);
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"> Filter Data</h3>
        <div class="box-tools pull-right">
            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body to-right">
        <form role="form" action="" method="get">
            <div class="col-md-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>&ensp;</label><br>
                        <a href="<?= current_url(); ?>" class="btn btn-info pull-right"><i class="fa fa-refresh"></i> <?= lang('filter'); ?> Reset </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>&ensp;</label><br>
                        <button class="btn btn-info pull-right" type="submit"><i class="fa fa-filter"></i> <?= lang('filter') . ' ' . lang('participant'); ?> </button>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label><?= lang('city'); ?></label>
                    <select name="city" class="form-control">
                        <option value="">All</option>
                        <?php foreach ($cites as $city) : ?>
                            <option value="<?= $city->city_id; ?>" <?= ($this->input->get('city') == $city->city_id) ? 'selected' : ''; ?>><?= $city->city_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label><?= lang('ideology_status'); ?></label>
                    <select name="ideology" class="form-control">
                        <option value="">All</option>
                        <?php foreach ($ideologies as $ideology) : ?>
                            <option value="<?= $ideology->ideology_id; ?>" <?= ($this->input->get('ideology') == $ideology->ideology_id) ? 'selected' : ''; ?>><?= $ideology->ideology_status; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label><?= lang('propagation_status'); ?></label>
                    <select name="propagation" class="form-control">
                        <option value="">All</option>
                        <?php foreach ($propagations as $propagation) : ?>
                            <option value="<?= $propagation->propagation_id; ?>" <?= ($this->input->get('propagation') == $propagation->propagation_id) ? 'selected' : ''; ?>><?= $propagation->propagation_status; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <?php if ($this->uri->segment(3) == 'panel') { ?>
                <hr>
                <div class="col-md-4" style="direction: ltr">
                    <div class="form-group">
                        <?php
                        $sessions = $this->input->get('sessions') ? $this->input->get('sessions') : 2;
                        ?>
                        <label># of sessions</label>
                        <select name="sessions" class="form-control" style="display:inline-block"
                                onchange="this.form.submit()">
                            <?php for ($i = 1; $i <= 5; $i++) : ?>
                                <option value="<?= $i; ?>" <?= ($sessions == $i) ? 'selected' : ''; ?>><?= $i; ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
            <?php } ?>
        </form>
    </div>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"> Participant of this event</h3>
        <div class="box-tools pull-right">
            <a class="btn btn-info" href="<?= site_url('registration/export_registration/' . $this->uri->segment(3)); ?>"> Export </a>
            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>


    <div class="box-body">
        <?php if ($attendance): ?>
            <table id="data_table" class="table table-bordered table-hover urdu-direction registration">
                <thead>
                <tr>
                    <?php if ($this->uri->segment(3) == 'desk'): ?>
                        <th><?= lang('signature'); ?></th>
                        <th><?= lang('arrival_time'); ?></th>
                    <?php elseif ($this->uri->segment(3) == 'panel'): ?>
                        <?php for ($i = $sessions; $i > 0; $i--) : ?>
                            <th><?= lang("session_{$i}"); ?></th>
                        <?php endfor; ?>
                    <?php elseif ($this->uri->segment(3) == 'present' or $this->uri->segment(3) == 'absent' or $this->uri->segment(3) == 'leave'): ?>
                        <?php if ($this->uri->segment(3) == 'leave'): ?>
                            <th><?= lang('time') . ' ' . lang('leave'); ?></th>
                        <?php endif; ?>
                        <th><?= lang('arrival_time'); ?></th>
                        <th><?= lang('attendance'); ?></th>
                    <?php endif; ?>
                    <th><?= lang('center'); ?></th>
                    <th><?= lang('ideology_status'); ?></th>
                    <th><?= lang('father_name'); ?></th>
                    <th><?= lang('name'); ?></th>
                    <th>ID</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($attendance as $participant): ?>
                    <tr>
                        <?php if ($this->uri->segment(3) == 'present' or $this->uri->segment(3) == 'absent' or $this->uri->segment(3) == 'leave'): ?>
                            <?php if ($this->uri->segment(3) == 'leave'): ?>
                                <td class="to-left time"><?= date('F d, Y g:i a', strtotime($participant->leave_date_time)); ?></td>
                            <?php endif; ?>
                            <td class="to-left time"><?= ($participant->registration_status) ? date('F d, Y g:i a', strtotime($participant->registration_time)) : ''; ?></td>
                            <th><?= ($participant->registration_status) ? lang('present') : lang('absent'); ?></th>
                        <?php elseif ($this->uri->segment(3) == 'panel'): ?>
                            <?php for ($i = 1; $i <= $sessions; $i++) : ?>
                                <th>&ensp;</th>
                            <?php endfor; ?>
                        <?php else: ?>
                            <td>&ensp;</td>
                            <td>&ensp;</td>
                        <?php endif; ?>
                        <td><?= $participant->city_name; ?></td>
                        <td><?= $event['selected_majlis_amomi'] && $participant->majlis_amomi_status?$participant->majlis_amomi_status:$participant->ideology_status; ?></td>
                        <td><?= $participant->father_name; ?></td>
                        <td><?= $participant->name; ?></td>
                        <td><?= $participant->participant_id; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <?php if ($this->uri->segment(3) == 'desk'): ?>
                        <th><?= lang('signature'); ?></th>
                        <th><?= lang('arrival_time'); ?></th>
                    <?php elseif ($this->uri->segment(3) == 'panel'): ?>
                        <?php for ($i = $sessions; $i > 0; $i--) : ?>
                            <th><?= lang("session_{$i}"); ?></th>
                        <?php endfor; ?>
                    <?php elseif ($this->uri->segment(3) == 'present' or $this->uri->segment(3) == 'absent' or $this->uri->segment(3) == 'leave'): ?>
                        <?php if ($this->uri->segment(3) == 'leave'): ?>
                            <th><?= lang('time') . ' ' . lang('leave'); ?></th>
                        <?php endif; ?>
                        <th><?= lang('arrival_time'); ?></th>
                        <th><?= lang('attendance'); ?></th>
                    <?php endif; ?>
                    <th><?= lang('center'); ?></th>
                    <th><?= lang('ideology_status'); ?></th>
                    <th><?= lang('father_name'); ?></th>
                    <th><?= lang('name'); ?></th>
                    <th>ID</th>
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
<?php if ($event): ?>
    <div id="print_page_header_message" class="hidden">
        <!--Main heading for print-->
        <?= $event['event_header'] ?>
        <!--Sub heading for print-->
        <div class="text-center">
            <p><?= lang('event_location'); ?> :<?= $event['event_location']; ?></p>
            <p><?= date('F d, Y', strtotime($event['event_date'])); ?> : <?= lang('event_date'); ?></p>

            <p>
                <?php
                if ($this->uri->segment(3) == 'desk'):
                    echo lang('attendance_sheet');
                elseif ($this->uri->segment(3) == 'panel'):
                    echo lang('attendance_sheet_hall');
                elseif ($this->uri->segment(3) == 'present'):
                    echo lang('participant') . ' ' . lang('present');
                elseif ($this->uri->segment(3) == 'absent'):
                    echo lang('participant') . ' ' . lang('absent');
                elseif ($this->uri->segment(3) == 'leave'):
                    echo lang('participant') . ' ' . lang('leave');
                endif;
                ?>
            </p>
        </div>
    </div>
<?php endif; ?>
