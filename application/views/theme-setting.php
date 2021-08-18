<?php
//echo '<pre>';
//print_r($gc_themes);
?>
<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Theme Settings</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <form role="form" action="<?= site_url('admin/theme_setting'); ?>" method="post">
            <div class="form-group">
                <label>Listing theme for admin</label>
                <select class="form-control" name="active_gc_theme_for_admin">
                    <?php foreach ($gc_themes as $theme): ?>
                        <option value="<?= $theme['value'];?>" <?= ($theme['value'] == $active_theme) ? 'selected' : ''; ?>><?= $theme['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Admin editor</label>
                <select class="form-control" name="active_gc_theme_for_admin">
                    <?php foreach ($gc_editors as $editor): ?>
                        <option value="<?= $editor['value'];?>" <?= ($editor['value'] == $active_editor) ? 'selected' : ''; ?>><?= $editor['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="box-footer">
                    <button class="btn btn-info pull-right" type="submit">Save</button>
                  </div>
        </form>
    </div><!-- /.box-body -->
</div>