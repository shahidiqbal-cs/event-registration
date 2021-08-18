<?php if ($summary): ?>
    <div class="nav-tabs-custom" id="print_section">
        <ul class="nav nav-tabs hidden-print">
            <?php foreach ($summary as $key => $summary_part): ?>
                <li class="<?= ($key == 0) ? 'active' : ''; ?>"><a href="#tab_<?= $key; ?>" data-toggle="tab"><?= $summary_part['ideology']->ideology_status; ?></a></li>
            <?php endforeach; ?>
            <li class=""><a href="#tab_overall_summary" data-toggle="tab"><?= lang('summary'); ?></a></li>
            <li class="pull-right"><button class="btn btn-default" id="print_summary"><i class="fa fa-print"></i> Print</button></li>
        </ul>
        <div class="tab-content">
            <?php foreach ($summary as $key => $summary_part): ?>
                <div class="tab-pane clearfix<?= ($key == 0) ? ' active' : ''; ?>" id="tab_<?= $key; ?>">
                    <div class="col-md-12 text-center">
                        <?= $event['event_header'] ?>
                        <p><?= date('F d, Y', strtotime($event['event_date'])); ?>,<?= $event['event_location'] ?></p>
                        <p><?= lang('summary'); ?> <?= lang('report'); ?> <?= lang('for'); ?> :<?= $summary_part['ideology']->ideology_status; ?></p>
                    </div>
                    <table class="table table-bordered table-striped group-table text-center">
                        <thead>
                            <tr>
                                <th><?= lang('percentage'); ?> <?= lang('attendance'); ?></th>
                                <th><?= lang('present'); ?></th>
                                <th><?= lang('absent'); ?></th>
                                <th><?= lang('leave'); ?></th>
                                <th><?= lang('total'); ?></th>
                                <th><?= lang('halqa'); ?></th>
                                <th><?= lang('city'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($summary_part['city'] as $city):
                                $marge_column = true;
                                foreach ($city['halqa'] as $halqa):
                                    ?>
                                    <tr>
                                        <td><?= ($halqa['total']) ? round(((($halqa['present'] + $halqa['leave']) / $halqa['total']) * 100), 2) : '0'; ?>%</td>
                                        <td><?= $halqa['present']; ?></td>
                                        <td><?= $halqa['absent']; ?></td>
                                        <td><?= $halqa['leave']; ?></td>
                                        <td><?= $halqa['total']; ?></td>
                                        <td><?= $halqa['halqa_detail']->halqa_name; ?></td>
                                        <?php if ($marge_column): ?>
                                            <th rowspan="<?= (count($city['halqa']) + 1); ?>"><?= $city['city_detail']->city_name; ?></th>
                                            <?php
                                            $marge_column = false;
                                        endif;
                                        ?>
                                    </tr>
                                <?php endforeach; ?>
                                <tr  class="row-seprater">
                                    <td><?= ($city['total']) ? round(((($city['present'] + $city['leave']) / $city['total']) * 100), 2) : '0'; ?>%</td>
                                    <td><?= $city['present']; ?></td>
                                    <td><?= $city['absent']; ?></td>
                                    <td><?= $city['leave']; ?></td>
                                    <td><?= $city['total']; ?></td>
                                    <td>&ensp;</td>
                                </tr>
                                <?php
                            endforeach;
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?= ($summary_part['total']) ? round(((($summary_part['present'] + $summary_part['leave']) / $summary_part['total']) * 100), 2) : '0'; ?>%</th>
                                <th><?= $summary_part['present']; ?></th>
                                <th><?= $summary_part['absent']; ?></th>
                                <th><?= $summary_part['leave']; ?></th>
                                <th><?= $summary_part['total']; ?></th>
                                <th>&ensp;</th>
                                <th>&ensp;</th>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="col-md-12">
                        <div class="col-md-6 pull-right text-center">
                            <span>____________________</span> :<?= lang('signature') . ' ' . lang('chairman'); ?>
                        </div>
                        <div class="col-md-6 text-center">
                            <p><u><?= date('d-M-Y g:i a'); ?></u> :<?= lang('time'); ?></p>
                        </div>
                    </div>
                </div><!-- /.tab-pane -->
            <?php endforeach; ?>
            <!--OverAll summary-->
            <div class="tab-pane clearfix" id="tab_overall_summary">
                <div class="col-md-12 text-center">
                    <?= $event['event_header'] ?>
                    <p><?= date('F d, Y', strtotime($event['event_date'])); ?>,<?= $event['event_location'] ?></p>
                    <p><?= lang('summary'); ?> <?= lang('report'); ?> <?= lang('for'); ?> :<?= $event['organizer_name']; ?></p>
                </div>
                <table class="table table-bordered table-striped group-table text-center">
                    <thead>
                        <tr>
                            <th><?= lang('percentage'); ?> <?= lang('attendance'); ?></th>
                            <th><?= lang('present'); ?></th>
                            <th><?= lang('absent'); ?></th>
                            <th><?= lang('leave'); ?></th>
                            <th><?= lang('total'); ?></th>
                            <th><?= lang('city'); ?></th>
                            <?php if (count($summary) > 1): ?>
                                <th><?= lang('ideology_status'); ?></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $overall_present = 0;
                        $overall_absent = 0;
                        $overall_leave = 0;
                        $overall_total = 0;
                        foreach ($summary as $key => $summary_ideology):
                            $marge_column = true;
                            $overall_present += $summary_ideology['present'];
                            $overall_absent += $summary_ideology['absent'];
                            $overall_leave += $summary_ideology['leave'];
                            $overall_total += $summary_ideology['total'];
                            ?>
                            <?php foreach ($summary_ideology['city'] as $city): ?>
                                <tr>
                                    <td><?= ($city['total']) ? round(((($city['present'] + $city['leave']) / $city['total']) * 100), 2) : '0'; ?>%</td>
                                    <td><?= $city['present']; ?></td>
                                    <td><?= $city['absent']; ?></td>
                                    <td><?= $city['leave']; ?></td>
                                    <td><?= $city['total']; ?></td>
                                    <td><?= $city['city_detail']->city_name; ?></td>
                                    <?php if (count($summary) > 1): ?>
                                        <?php if ($marge_column): ?>
                                            <th rowspan="<?= (count($summary_ideology['city']) + 1); ?>"><?= $summary_ideology['ideology']->ideology_status; ?></th>
                                            <?php
                                            $marge_column = false;
                                        endif;
                                    endif;
                                    ?>
                                </tr>
                            <?php endforeach; ?>
                            <tr class="row-seprater">
                                <td><?= ($summary_ideology['total']) ? round(((($summary_ideology['present'] + $summary_ideology['leave']) / $summary_ideology['total']) * 100), 2) : '0'; ?>%</td>
                                <td><?= $summary_ideology['present']; ?></td>
                                <td><?= $summary_ideology['absent']; ?></td>
                                <td><?= $summary_ideology['leave']; ?></td>
                                <td><?= $summary_ideology['total']; ?></td>
                                <td>&ensp;</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th><?= ($overall_total) ? round(((($overall_present + $overall_leave) / $overall_total) * 100), 2) : '0'; ?>%</th>
                            <th><?= $overall_present; ?></th>
                            <th><?= $overall_absent; ?></th>
                            <th><?= $overall_leave; ?></th>
                            <th><?= $overall_total; ?></th>
                            <th>&ensp;</th>
                            <th>&ensp;</th>
                        </tr>
                    </tfoot>
                </table>
                <div class="col-md-12">
                    <div class="col-md-6 pull-right text-center">
                        <span>____________________</span> :<?= lang('signature') . ' ' . lang('chairman'); ?>
                    </div>
                    <div class="col-md-6 text-center">
                        <p><u><?= date('d-M-Y g:i a'); ?></u> :<?= lang('time'); ?></p>
                    </div>
                </div>
            </div>
            <!--End OverAll summary-->
        </div><!-- /.tab-content -->
    </div><!-- nav-tabs-custom -->
<?php endif; ?>