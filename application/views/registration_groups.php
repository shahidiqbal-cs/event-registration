<?php if ($groups): ?>
    <div class="nav-tabs-custom" id="print_section">
        <ul class="nav nav-tabs hidden-print">
            <?php foreach ($groups as $key => $group): ?>
                <li class="<?= ($key == 1) ? 'active' : ''; ?>"><a href="#tab_<?= $key; ?>" data-toggle="tab">Group # <?= $key; ?></a></li>
            <?php endforeach; ?>
            <li class="pull-right"><button id="" class="btn btn-default" onclick="window.print()"><i class="fa fa-print"></i> Print</button></li>
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
                        <div id="groups" class="col-xs-12 text-center to-right">
                            <div class="row">
                                <div class="col-xs-6"><?= lang('groups_questions'); ?></div>
                                <div class="col-xs-1"><?= lang('attendance'); ?></div>
                                <div class="col-xs-2"><?= lang('city'); ?></div>
                                <div class="col-xs-2"><?= lang('name'); ?></div>
                                <div class="col-xs-1">ID</div>
                            </div>
                            <?php foreach ($group as $participant): ?>
                                <div class="row">
                                    <div class="col-xs-6">&ensp;</div>
                                    <div class="col-xs-1">&ensp;</div>
                                    <div class="col-xs-2"><?= $participant->city_name; ?></div>
                                    <div class="col-xs-2"><?= $participant->name; ?></div>
                                    <div class="col-xs-1"><?= $participant->participant_id; ?></div>
                                </div>
                            <?php endforeach; ?>
                            <?php if (count($group) < 13): ?>
                                <?php for ($i = 0; $i < (13 - count($group)); $i++): ?>
                                    <div class="row">
                                        <div class="col-xs-6">&ensp;</div>
                                        <div class="col-xs-1">&ensp;</div>
                                        <div class="col-xs-2">&ensp;</div>
                                        <div class="col-xs-2">&ensp;</div>
                                        <div class="col-xs-1">&ensp;</div>
                                    </div>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </div>

                        <br>
                        <div id="group_footer" class="row">
                            <div class="col-xs-12">
                                <div class="col-xs-10">__________________________________________________________________________</div>
                                <div class="col-xs-2"> :<?= lang('views'); ?></div>
                            </div>
                            <div class="col-xs-12">
                                <div class="col-xs-10">__________________________________________________________________________</div>
                                <div class="col-xs-2">&ensp;</div>
                            </div>
                            <br />
                            <div class="col-sm-12" style="margin-top: 45px;">
                                <div class="col-xs-4">_____________________________</div>
                                <div class="col-xs-3"> :<?= lang('signature') . ' ' . lang('group') . ' ' . lang('leader'); ?></div>
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