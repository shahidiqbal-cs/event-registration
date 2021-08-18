<div class="box box-primary">    
    <div class="box-header with-border">
        <h3 class="box-title"> <a href="<?= site_url('organization/city/new'); ?>" class="btn btn-block btn-default"> Add new city</a></h3>
        <div class="box-tools pull-right">
            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>


    <div class="box-body">
        <?php if ($cities): ?>
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th><?= lang('additional') . ' ' . lang('information'); ?></th>
                        <th><?= lang('zone'); ?></th>
                        <th><?= lang('city'); ?></th>
                        <th>ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cities as $city): ?>
                        <tr>
                            <td><?= $city->city_description; ?></td>
                            <td><?= $city->zone_name; ?></td>
                            <td><?= $city->city_name; ?></td>
                            <td><?= $city->city_id; ?></td>
                            <td>
                                <a title="Delete Halqa" href="<?= site_url('organization/city/delete/' . $city->city_id); ?>" data-confirm="Are you sure you want to delete?"><i class="fa fa-trash"></i></a>&ensp;
                                <a title="Edit Halqa Info" href="<?= site_url('organization/city/edit/' . $city->city_id); ?>"><i class="fa fa-edit"></i></a>&ensp;
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