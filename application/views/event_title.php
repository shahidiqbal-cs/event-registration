<div class="box box-primary">    
    <div class="box-header with-border">
        <h3 class="box-title"> <a href="<?= site_url('title/create'); ?>" class="btn btn-block btn-default"> Add new title</a></h3>
        <div class="box-tools pull-right">
            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>


    <div class="box-body">
        <?php if ($titles): ?>
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th><?= lang('additional') . ' ' . lang('information'); ?></th>
                        <th><?= lang('event_name'); ?></th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($titles as $title): ?>
                    <tr class="to-right">
                            <td><?= $title->title_description; ?></td>
                            <td><?= $title->event_title; ?></td>
                            <td>
                                <a title="Delete Title" href="<?= site_url('title/delete/' . $title->title_id); ?>" data-confirm="Are you sure you want to delete title?"><i class="fa fa-trash"></i></a>&ensp;
                                <a title="Edit Title Info" href="<?= site_url('title/edit/' . $title->title_id); ?>"><i class="fa fa-edit"></i></a>&ensp;
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