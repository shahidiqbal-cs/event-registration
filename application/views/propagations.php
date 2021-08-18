<div class="box box-primary">    
    <div class="box-header with-border">
        <h3 class="box-title"> <a href="<?= site_url('propagation/propagation/new'); ?>" class="btn btn-block btn-default"> Add new</a></h3>
        <div class="box-tools pull-right">
            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>


    <div class="box-body">
        <?php if ($propagations): ?>
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th><?= lang('additional') . ' ' . lang('information'); ?></th>
                        <th><?= lang('propagation_status'); ?></th>
                        <th>ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($propagations as $propagation): ?>
                        <tr>
                            <td><?= $propagation->propagation_description; ?></td>
                            <td><?= $propagation->propagation_status; ?></td>
                            <td><?= $propagation->propagation_id; ?></td>
                            <td>
                                <a title="Delete propagation" href="<?= site_url('propagation/propagation/delete/' . $propagation->propagation_id); ?>" data-confirm="Are you sure you want to delete?"><i class="fa fa-trash"></i></a>&ensp;
                                <a title="Edit propagation Info" href="<?= site_url('propagation/propagation/edit/' . $propagation->propagation_id); ?>"><i class="fa fa-edit"></i></a>&ensp;
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