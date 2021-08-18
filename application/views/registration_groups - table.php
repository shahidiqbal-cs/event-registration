<?php if ($groups): ?>
    <div class="nav-tabs-custom" id="print_section">
        <ul class="nav nav-tabs hidden-print">
            <?php foreach ($groups as $key => $group): ?>
                <li class="<?= ($key == 1) ? 'active' : ''; ?>"><a href="#tab_<?= $key; ?>" data-toggle="tab">Group # <?= $key; ?></a></li>
            <?php endforeach; ?>
            <li class="pull-right"><button class="btn btn-default" id="print_summary"><i class="fa fa-print"></i> Print</button></li>
        </ul>
        <div class="tab-content">
            <?php foreach ($groups as $key => $group): ?>
                <div class="tab-pane<?= ($key == 1) ? ' active' : ''; ?>" id="tab_<?= $key; ?>">
                    <b><?= $event['event_header']; ?></b>
                    <!--<hr>-->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-6 pull-right" style="text-align: right;">_______________________ : <?= lang('group') . ' ' . lang('leader'); ?></div>
                            <div class="col-sm-6">_______________________ : <?= lang('group') . ' ' . lang('secretary'); ?></div>
                        </div>
                        <br>
                        <div class="col-sm-12">
                            <div class="col-sm-6 pull-right" style="text-align: right;"> <?= $key; ?> : <?= lang('group') . ' ' . lang('number'); ?></div>
                            <div class="col-sm-6">_______________________ : <?= lang('place'); ?></div>
                        </div>
                    </div>
                    <br />
                    <?php if ($group): ?>
                        <table class="table table-bordered table-striped group-table">
                            <thead>
                                <tr>
                                    <th><?= lang('groups_questions'); ?></th>
                                    <th><?= lang('attendance'); ?></th>
                                    <th><?= lang('halqa'); ?></th>
                                    <th><?= lang('name'); ?></th>
                                    <th>ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($group as $participant): ?>
                                    <tr>
                                        <td>&ensp;</td>
                                        <td>&ensp;</td>
                                        <td><?= $participant->halqa_name; ?></td>
                                        <td><?= $participant->name; ?></td>
                                        <td><?= $participant->participant_id; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (count($group) < 13): ?>
                                    <?php for ($i = 0; $i < (13 - count($group)); $i++): ?>
                                        <tr>
                                            <td>&ensp;</td>
                                            <td>&ensp;</td>
                                            <td>&ensp;</td>
                                            <td>&ensp;</td>
                                            <td>&ensp;</td>
                                        </tr>
                                    <?php endfor; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <br>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="col-sm-10 pull-left">_________________________________________________________________________________ :  </div>
                                <div class="col-sm-2 pull-right"><?= lang('views'); ?></div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-10  pull-left">________________________________________________________________________________</div>
                                <div class="col-sm-2 pull-right">&ensp;</div>
                            </div>
                            <br />
                            <div class="col-sm-12">
                                <div class="col-sm-3 pull-left" style="width: 50%;">_______________________________________________:</div>
                                <div class="col-sm-3 pull-right"> :<?= lang('signature') . ' ' . lang('group') . ' ' . lang('leader'); ?></div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
                            No Result found.
                        </div>
                    <?php endif; ?>
                </div><!-- /.tab-pane -->
            <?php endforeach; ?>
        </div><!-- /.tab-content -->
    </div><!-- nav-tabs-custom -->
<?php endif; ?>