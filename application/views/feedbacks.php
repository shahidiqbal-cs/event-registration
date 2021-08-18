<div class="box box-primary">    
    <div class="box-header with-border">
        <h3 class="box-title"> <a href="<?= site_url('feedback/create'); ?>" class="btn btn-block btn-default"> Post new</a></h3>
        <div class="box-tools pull-right">
            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>


    <div class="box-body">
        <?php if ($feedbacks): ?>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Feedback</th>
                        <th>Feedback Developer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feedbacks as $feedback): ?>
                    <tr>
                            <td><?= $feedback->feedback_type; ?></td>
                            <td><?= $feedback->feedbacker_name; ?></td>
                            <td><?= $feedback->feedback; ?></td>
                            <td><?= $feedback->feedback_dev; ?></td>
                            <td class="text-center"><a title="Edit" href="<?= site_url('feedback/edit/' . $feedback->feedback_id); ?>"><i class="fa fa-edit"></i></a>&ensp;</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
                No Feedback found.
            </div>
        <?php endif; ?>

    </div><!-- /.box-body -->
</div><!-- /.box -->