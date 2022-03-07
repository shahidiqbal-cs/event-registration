<div class="box box-primary">    
    <div class="box-header with-border">
        <h3 class="box-title"> </h3>
        <div class="box-tools pull-right">
            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>


    <div class="box-body">
        <?php if ($regions): ?>
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th><?= lang('additional') . ' ' . lang('information'); ?></th>
                        <th><?= lang('region'); ?></th>
                        <th>ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($regions as $region): ?>
                        <tr>
                            <td><?= $region->region_description; ?></td>
                            <td><?= $region->region_name; ?></td>
                            <td><?= $region->region_id; ?></td>
                            <td>
                                <a title="Edit <?= lang('region') ?> Info" href="<?= site_url('organization/region/edit/' . $region->region_id); ?>"><i class="fa fa-edit"></i></a>&ensp;
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