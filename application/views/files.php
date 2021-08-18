<div class="box box-primary">    
    <div class="box-header with-border">
        <h3 class="box-title">Files</h3>
        <div class="box-tools pull-right">
            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>


    <div class="box-body">
        <?php if (user_role() == 'admin'): ?>
            <div class="row">
                <div class="col-sm-12" style="margin-bottom: 16px;">
                    <form action="<?= site_url('file/upload'); ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-sm-7"></div>
                            <div class="col-sm-3">
                                <input type="file" name="file"/>
                            </div>
                            <div class="col-sm-2"><button class="btn btn-primary" type="submit"><i class="fa fa-upload"></i> Upload File</button></div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($files): ?>
            <table class="table table-bordered table-striped text-center">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Date Modified</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($files as $file): ?>
                        <tr>
                            <td style="text-align: left;"><i class="fa <?= $file['fa_icon']; ?>"></i> <?= $file['type'] ?></td>
                            <td style="text-align: left;"><?= $file['file_name']; ?></td>
                            <td><?= $file['size_with_unit']; ?></td>
                            <td><?= date('d M Y', $file['date']); ?></td>
                            <td>
                                <a class="btn btn-primary" href="<?= $file['server_path']; ?>"><i class="fa fa-download"></i></a>&ensp;
                                <?php if (user_role() == 'admin'): ?>
                                    <a title="Delete File" class="btn btn-primary" href="<?= site_url('file/delete') . '/?file_url=' . $file['server_path']; ?>" data-confirm="Are you sure you want to delete?"><i class="fa fa-trash"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
                No File found.
            </div>
        <?php endif; ?>
    </div><!-- /.box-body -->
</div><!-- /.box -->