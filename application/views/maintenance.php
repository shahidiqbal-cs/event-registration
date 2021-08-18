<?php
if ($this->session->flashdata('success')):
    logout();
endif;
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"> Backup</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="col-md-6">
            <div class="alert alert-info">
                <i class="icon fa fa-info"></i>Please choose <strong>save</strong> option on download.
            </div>
        </div>
        <div class="col-md-6">
            <!--<div class="form-group">-->
            <p>This feature will create a database file.</p>
            <p>That can be use any other computer with same data. This can be a backup file.</p>
        </div>

    </div><!-- /.box-body -->
    <!-- form start -->
    <form role="form">
        <div class="box-footer">
            <a href="<?= site_url('maintenance/backup'); ?>" class="btn btn-primary pull-right">Yes Export Please</a>
            <!--<button type="submit" class="btn btn-primary">Export</button>-->
        </div>
    </form>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"> Import</h3>
    </div><!-- /.box-header -->



    <!-- form start -->
    <form role="form" action="<?= site_url('maintenance/import'); ?>" method="POST" enctype="multipart/form-data">
        <div class="box-body">
            <div class="col-md-6">
                <div class="alert alert-warning">
                    <i class="icon fa fa-warning"></i>
                    This feature may cause
                    <ul>
                        <li>Remove old data From database and add new data.</li>
                        <li>Corrupted File may erase all data.</li>
                    </ul>
                </div>
                <div class="alert alert-info">
                    <i class="icon fa fa-info"></i>
                    Before using this feature
                    <ul>
                        <li>Backup database.</li>
                        <li>Make sure you are uploading valid file.</li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <p>This feature set data from the file you will upload.</p>
                <div class="form-group">
                    <label for="exampleInputFile">Select SQL file: </label>
                    <input type="file" name="sqlfile">
                </div>

                <?php if ($this->session->flashdata('error')): ?>
                    <br>
                    <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
                        <i class="icon fa fa-ban"></i> <?= $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

            </div>
        </div><!-- /.box-body -->

        <div class="box-footer">
            <button type="submit" class="btn btn-primary pull-right"> Restore over database</button>
        </div>
    </form>
</div>
