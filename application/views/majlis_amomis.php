<div class="box box-primary">    
    <div class="box-header with-border">
        <h3 class="box-title"> <a href="<?= site_url('majlis_amomi/create'); ?>" class="btn btn-block btn-default"> Add new</a></h3>
        <div class="box-tools pull-right">
            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>


    <div class="box-body">
        <?php if ($majlis_amomis): ?>
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th><?= lang('additional') . ' ' . lang('information'); ?></th>
                        <th><?= lang('majlis_amomi'); ?></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($majlis_amomis as $majlis_amomi): ?>
                    <tr class="to-right">
                            <td><?= $majlis_amomi->majlis_amomi_description; ?></td>
                            <td><?= $majlis_amomi->majlis_amomi_status; ?></td>
                            <td>
                                <a title="Delete majlis amomi" href="<?= site_url('majlis_amomi/delete/' . $majlis_amomi->majlis_amomi_id); ?>" data-confirm="Are you sure you want to delete majlis amomi?"><i class="fa fa-trash"></i></a>&ensp;
                                <a title="Edit majlis amomi Info" href="<?= site_url('majlis_amomi/edit/' . $majlis_amomi->majlis_amomi_id); ?>"><i class="fa fa-edit"></i></a>&ensp;
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
                No Result found.
            </div>
        <?php endif; ?>

    </div><!-- /.box-body -->
</div><!-- /.box -->