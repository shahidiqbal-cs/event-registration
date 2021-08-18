<div class="box box-primary">    
    <div class="box-header with-border">
        <h3 class="box-title"> Events</h3>
        <div class="box-tools pull-right">
            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>


    <div class="box-body">
        <?php if ($events): ?>
            <table id="data_table" class="table table-bordered table-striped to-right">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Status</th>
                        <th><?= lang('event_date'); ?></th>
                        <th><?= lang('event_name'); ?></th>
                        <th><?= lang('event'); ?></th>
                        <th><?= lang('participant'); ?></th>
                        <th><?= lang('event_arrange_by'); ?></th>
                        <th><?= lang('event_location'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                        <?php $active_event = ($this->session->userdata('active_event') == $event->event_id) ? true : false; ?>
                        <tr>
                            <td>
                                <?php if (user_role() == 'admin'): ?>
                                    <a title="Delete Event" href="<?= site_url('event/delete/' . $event->event_id); ?>" data-confirm="Are you sure you want to delete?"><i class="fa fa-trash"></i></a>&ensp;
                                    <a title="Edit Event Info" href="<?= site_url('event/update/' . $event->event_id); ?>"><i class="fa fa-edit"></i></a>&ensp;
                                <?php endif; ?>
                                <a title="View detail of event" href="<?= site_url('event/read/' . $event->event_id); ?>"><i class="fa fa-eye"></i></a>&ensp;
                                <a title="Toggle event Activation" href="<?= site_url('event/active/' . $event->event_id); ?>"><i class="fa fa-power-off <?= ($active_event) ? 'text-green' : 'text-red'; ?>"></i></a>
                            </td>
                            <td><span class="label label-<?= ($active_event) ? 'success' : 'warning'; ?>"><?= ($active_event) ? 'Active' : 'Deactive'; ?></span></td>
                            <td><?= date('d-m-Y', strtotime($event->event_date)); ?></td>
                            <td><?= $event->event_name; ?></td>
                            <td><?= $event->event_type; ?></td>
                            <td><?= $event->participant_types; ?></td>
                            <td><?= $event->organizer_name . ' (' . $event->organizer_urdu . ')'; ?></td>
                            <td><?= $event->event_location; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Action</th>
                        <th>Status</th>
                        <th><?= lang('event_date'); ?></th>
                        <th><?= lang('event_name'); ?></th>
                        <th><?= lang('participant'); ?></th>
                        <th><?= lang('event_arrange_by'); ?></th>
                        <th><?= lang('event_location'); ?></th>
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