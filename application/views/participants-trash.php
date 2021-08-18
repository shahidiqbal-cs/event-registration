<?php $formAttributes = 'class="form-control"'; ?>
<div class="box box-primary">    
    <div class="box-header with-border">
        <h3 class="box-title"> Filter Data</h3>
        <div class="box-tools pull-right">
            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
            <button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-box-tool" data-original-title="Remove"><i class="fa fa-times"></i></button>
        </div>
    </div>
    <div class="box-body to-right">
        <form role="form" action="" method="get">
            <div class="col-md-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>&ensp;</label><br>
                        <a href="<?= current_url(); ?>" class="btn btn-info pull-right"><i class="fa fa-refresh"></i> <?= lang('filter'); ?> Reset </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>&ensp;</label><br>
                        <button class="btn btn-info pull-right" type="submit"><i class="fa fa-filter"></i> <?= lang('filter') . ' ' . lang('participant'); ?> </button>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label><?= lang('city'); ?></label>
                    <select name="city" class="form-control">
                        <option value=""> Show All </option>
                        <?php foreach ($cites as $city) : ?>
                            <option value="<?= $city->city_id; ?>" <?= ($this->input->get('city') == $city->city_id) ? 'selected' : ''; ?>><?= $city->city_name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label><?= lang('ideology_status'); ?></label>
                    <select name="ideology" class="form-control">
                        <option value=""> Show All </option>
                        <?php foreach ($ideologies as $ideology) : ?>
                            <option value="<?= $ideology->ideology_id; ?>" <?= ($this->input->get('ideology') == $ideology->ideology_id) ? 'selected' : ''; ?>><?= $ideology->ideology_status; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label><?= lang('propagation_status'); ?></label>
                    <select name="propagation" class="form-control">
                        <option value=""> Show All </option>
                        <?php foreach ($propagations as $propagation) : ?>
                            <option value="<?= $propagation->propagation_id; ?>" <?= ($this->input->get('propagation') == $propagation->propagation_id) ? 'selected' : ''; ?>><?= $propagation->propagation_status; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

        </form>
    </div> 
</div>
<div class="box box-primary">    
    <div class="box-header with-border">
        <h3 class="box-title"> Participant Data</h3>
        <div class="box-tools pull-right">
            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
            <!--<button title="" data-toggle="tooltip" data-widget="remove" class="btn btn-box-tool" data-original-title="Remove"><i class="fa fa-times"></i></button>-->
        </div>
    </div>


    <div class="box-body">
        <?php if ($participants): ?>
            <table id="data_table" class="table table-bordered table-striped to-right">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>ID</th>
                        <th><?= lang('name'); ?></th>
                        <th><?= lang('father_name'); ?></th>
                        <th><?= lang('ideology_status'); ?></th>
                        <th><?= lang('contact_number'); ?></th>
                        <th><?= lang('status'); ?></th>
                        <th><?= lang('comment'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($participants as $participant): ?>
                        <tr>
                            <td>
                                <a href="<?= site_url('participant/trash_delete/' . $participant->participant_id); ?>" data-confirm="Are you sure you want to delete?"><i class="fa fa-trash"></i></a>&ensp;
                                <a target="_blank" href="<?= site_url('participant/update/' . $participant->participant_id); ?>"><i class="fa fa-edit"></i></a>&ensp;
                                <a href="<?= site_url('participant/trash_update/' . $participant->participant_id); ?>"><i class="fa fa-cogs"></i></a>&ensp;
                            </td>
                            <th><?= $participant->participant_id; ?></th>
                            <th><?= $participant->name; ?></th>
                            <th><?= $participant->father_name; ?></th>
                            <th><?= $participant->ideology_status; ?></th>
                            <th><?= $participant->participant_no; ?></th>
                            <th><?= ($participant->participant_status_text) ? lang($participant->participant_status_text) : ''; ?></th>
                            <th><?= $participant->comments; ?></th>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Action</th>
                        <th>ID</th>
                        <th><?= lang('name'); ?></th>
                        <th><?= lang('father_name'); ?></th>
                        <th><?= lang('ideology_status'); ?></th>
                        <th><?= lang('contact_number'); ?></th>
                        <th><?= lang('status'); ?></th>
                        <th><?= lang('comment'); ?></th>
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