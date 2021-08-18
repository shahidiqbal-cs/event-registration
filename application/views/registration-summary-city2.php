<?php if ($summary): ?>
    <div class="nav-tabs-custom" id="print_section">
        <ul class="nav nav-tabs">
            <?php foreach ($summary as $key => $summary_by_ideology): ?>
                <li class="<?= ($key == 0) ? 'active' : ''; ?>"><a href="#tab_<?= $key; ?>" data-toggle="tab"><?= $summary_by_ideology['ideology']->ideology_status; ?></a></li>
            <?php endforeach; ?>
            <li class=""><a href="#tab_overall_summary" data-toggle="tab"><?= lang('summary'); ?></a></li>
            <li class="pull-right"><button class="btn btn-default" id="print_summary"><i class="fa fa-print"></i> Print</button></li>
        </ul>
        <div class="tab-content">
            <?php foreach ($summary as $key => $summary_by_ideology): ?>
                <div class="tab-pane clearfix<?= ($key == 0) ? ' active' : ''; ?>" id="tab_<?= $key; ?>">
                    <div class="col-md-12 text-center">
                        <?= $event['event_header'] ?>
                        <p><?= date('F d, Y', strtotime($event['event_date'])); ?>,<?= $event['event_location'] ?></p>
                        <p><?= lang('summary') . ' ' . lang('report') . ' ' . lang('for'); ?> : <?= $summary_by_ideology['ideology']->ideology_status; ?></p>
                    </div>
                    <table class="table table-bordered table-striped group-table text-center">
                        <thead>
                            <tr>
                                <th><?= lang('percentage'); ?> <?= lang('attendance'); ?></th>
                                <th><?= lang('total'); ?></th>
                                <th><?= lang('present'); ?></th>
                                <th><?= lang('temporary') . ' ' . lang('leave'); ?></th>
                                <th><?= lang('leave'); ?></th>
                                <th><?= lang('absent'); ?></th>
                                <th><?= lang('halqa'); ?></th>
                                <th><?= lang('city'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cities_summary = $summary_by_ideology['cities'];
                            foreach ($cities_summary as $city_summary):
                                $marge_column = true;
                                foreach ($city_summary['halqas'] as $halqa_summary):
                                    ?>
                                    <tr>
                                        <td><?= ($halqa_summary['total']) ? round(((($halqa_summary['present']) / $halqa_summary['total']) * 100), 2) : '0'; ?>%</td>
                                        <td><?= $halqa_summary['total']; ?></td>
                                        <td><?= $halqa_summary['present']; ?></td>
                                        <td><?= $halqa_summary['half_leave']; ?></td>
                                        <td><?= $halqa_summary['full_leave']; ?></td>
                                        <td><?= $halqa_summary['absent']; ?></td>
                                        <td><?= $halqa_summary['details']->halqa_name; ?></td>
                                        <?php if ($marge_column): ?>
                                            <th rowspan="<?= ($city_summary['no_of_halqa'] + 1); ?>"><?= ($city_summary['details']->city_name != 'direct') ? $city_summary['details']->city_name : ''; ?></th>
                                            <?php
                                            $marge_column = false;
                                        endif;
                                        ?>
                                    </tr>
                                <?php endforeach; ?>
                                <tr  class="row-seprater">
                                    <td><?= ($city_summary['total']) ? round(((($city_summary['present'] + $city_summary['half_leave']) / $city_summary['total']) * 100), 2) : '0'; ?>%</td>
                                    <td><?= $city_summary['total']; ?></td>
                                    <td><?= $city_summary['present']; ?></td>
                                    <td><?= $city_summary['half_leave']; ?></td>
                                    <td><?= $city_summary['full_leave']; ?></td>
                                    <td><?= $city_summary['absent']; ?></td>
                                    <td>&ensp;</td>
                                </tr>
                                <?php
                            endforeach;
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th><?= ($summary_by_ideology['total']) ? round(((($summary_by_ideology['present'] + $summary_by_ideology['half_leave']) / $summary_by_ideology['total']) * 100), 2) : '0'; ?>%</th>
                                <th><?= $summary_by_ideology['total']; ?></th>
                                <th><?= $summary_by_ideology['present']; ?></th>
                                <th><?= $summary_by_ideology['half_leave']; ?></th>
                                <th><?= $summary_by_ideology['full_leave']; ?></th>
                                <th><?= $summary_by_ideology['absent']; ?></th>
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
                    <p><?= lang('summary') . ' ' . lang('report') ?> : <?= lang('overall') ; ?></p>
                </div>
                <table class="table table-bordered table-striped group-table text-center">
                    <thead>
                        <tr>
                            <th><?= lang('percentage'); ?> <?= lang('attendance'); ?></th>
                            <th><?= lang('total'); ?></th>
                            <th><?= lang('present'); ?></th>
                            <th><?= lang('temporary') . ' ' . lang('leave'); ?></th>
                            <th><?= lang('leave'); ?></th>
                            <th><?= lang('absent'); ?></th>
                            <th><?= lang('city'); ?></th>
                            <?php if (count($summary) > 1): ?>
                                <th><?= lang('ideology_status'); ?></th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $overall_total = 0;
                        $overall_present = 0;
                        $overall_half_leave = 0;
                        $overall_leave = 0;
                        $overall_absent = 0;
                        foreach ($summary as $key => $summary_by_ideology):
                            $marge_column = true;
                            $overall_total += $summary_by_ideology['total'];
                            $overall_present += $summary_by_ideology['present'];
                            $overall_half_leave += $summary_by_ideology['half_leave'];
                            $overall_leave += $summary_by_ideology['full_leave'];
                            $overall_absent += $summary_by_ideology['absent'];
                            $cities_summary = $summary_by_ideology['cities'];
                            ?>
                            <?php foreach ($cities_summary as $city_summary): ?>
                                <tr>
                                    <td><?= ($city_summary['total']) ? round(((($city_summary['present'] + $city_summary['half_leave']) / $city_summary['total']) * 100), 2) : '0'; ?>%</td>
                                    <td><?= $city_summary['total']; ?></td>
                                    <td><?= $city_summary['present']; ?></td>
                                    <td><?= $city_summary['half_leave']; ?></td>
                                    <td><?= $city_summary['full_leave']; ?></td>
                                    <td><?= $city_summary['absent']; ?></td>
                                    <td><?= $city_summary['details']->city_name; ?></td>
                                    <?php if (count($summary) > 1): ?>
                                        <?php if ($marge_column): ?>
                                            <th rowspan="<?= ($summary_by_ideology['no_of_city'] + 1); ?>"><?= $summary_by_ideology['ideology']->ideology_status; ?></th>
                                            <?php
                                            $marge_column = false;
                                        endif;
                                    endif;
                                    ?>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (count($summary) > 1): ?>
                                <tr class="row-seprater">
                                    <td><?= ($summary_by_ideology['total']) ? round(((($summary_by_ideology['present'] + $summary_by_ideology['half_leave']) / $summary_by_ideology['total']) * 100), 2) : '0'; ?>%</td>
                                    <td><?= $summary_by_ideology['total']; ?></td>
                                    <td><?= $summary_by_ideology['present']; ?></td>
                                    <td><?= $summary_by_ideology['half_leave']; ?></td>
                                    <td><?= $summary_by_ideology['full_leave']; ?></td>
                                    <td><?= $summary_by_ideology['absent']; ?></td>
                                    <td>&ensp;</td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th><?= ($overall_total) ? round(((($overall_present + $overall_half_leave) / $overall_total) * 100), 2) : '0'; ?>%</th>
                            <th><?= $overall_total; ?></th>
                            <th><?= $overall_present; ?></th>
                            <th><?= $overall_half_leave; ?></th>
                            <th><?= $overall_leave; ?></th>
                            <th><?= $overall_absent; ?></th>
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