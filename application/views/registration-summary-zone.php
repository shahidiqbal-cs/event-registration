<?php if ($summary): ?>
<div class="nav-tabs-custom" id="print_section">
        <ul class="nav nav-tabs hidden-print">
            <li class="active"><a href="#tab_overall_summary_zone" data-toggle="tab"><?= lang('summary') . ' ' . lang('zone'); ?></a></li>
            <li class=""><a href="#tab_overall_summary_zone_city" data-toggle="tab"><?= lang('summary') . ' ' . lang('zone') . ' + ' . lang('city'); ?></a></li>
            <li class=""><a href="#tab_overall_summary_city" data-toggle="tab"><?= lang('summary') . ' ' . lang('city'); ?></a></li>
            <li class="pull-right"><button class="btn btn-default" id="" onclick="window.print()"><i class="fa fa-print"></i> Print</button></li>
        </ul>
        <div class="tab-content">
            <!--OverAll summary-->
            <div class="tab-pane clearfix active" id="tab_overall_summary_zone">
                <div class="col-md-12 text-center">
                    <?= $event['event_header'] ?>
                    <p><?= date('F d, Y', strtotime($event['event_date'])); ?>,<?= $event['event_location'] ?></p>
                    <p><?= lang('summary') . ' ' . lang('report') ?> : <?= lang('overall'); ?></p>
                </div>
                <table class="table table-bordered table-striped group-table text-center">
                    <thead>
                        <tr>
                            <th><?= lang('percentage'); ?> <?= lang('attendance'); ?></th>
                            <th><?= lang('total'); ?></th>
                            <th><?= lang('present'); ?></th>
                            <th><?= lang('leave'); ?></th>
                            <th><?= lang('absent'); ?></th>
                            <th><?= lang('zone'); ?></th>
                            <?php if (count($summary) > 1): ?>
                                <th><?= lang('status'); ?></th>
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
                        foreach ($summary as $key => $summary_by_type):
                            $marge_column = true;
                            $overall_total += $summary_by_type['total'];
                            $overall_present += $summary_by_type['present'];
                            $overall_half_leave += $summary_by_type['half_leave'];
                            $overall_leave += $summary_by_type['full_leave'];
                            $overall_absent += $summary_by_type['absent'];
                            foreach ($summary_by_type['zones'] as $zone_summary):
                                ?>
                                <tr>
                                    <td><?= ($zone_summary['total']) ? round(((($zone_summary['present'] + $zone_summary['half_leave']) / ($zone_summary['total'])) * 100), 2) : '0'; ?>%</td>
                                    <td><?= $zone_summary['total']; ?></td>
                                    <td><?= $zone_summary['present']; ?></td>
                                    <td><?= $zone_summary['full_leave']; ?></td>
                                    <td><?= $zone_summary['absent']; ?></td>
                                    <th rowspan=""><?= ($zone_summary['details']->zone_name != 'direct') ? $zone_summary['details']->zone_name : '(' . lang('region') . ')'; ?></th>
                                    <?php
                                    if (count($summary) > 1):
                                        ?>
                                        <?php if ($marge_column): ?>
                                            <th rowspan="<?= count($summary_by_type['zones']) + 1; ?>"><?= $summary_by_type['event_type_heading']; ?></th>
                                            <?php
                                            $marge_column = false;
                                        endif;
                                    endif;
                                    ?>
                                </tr>        
                            <?php endforeach; ?>
                            <?php if (count($summary) > 1): ?>
                                <tr class="row-seprater">
                                    <td><?= ($summary_by_type['total']) ? round(((($summary_by_type['present'] + $summary_by_type['half_leave']) / ($summary_by_type['total'])) * 100), 2) : '0'; ?>%</td>
                                    <td><?= $summary_by_type['total']; ?></td>
                                    <td><?= $summary_by_type['present']; ?></td>
                                    <td><?= $summary_by_type['full_leave']; ?></td>
                                    <td><?= $summary_by_type['absent']; ?></td>
                                    <td><?= lang('total'); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <tr>
                            <th><?= ($overall_total) ? round(((($overall_present + $overall_half_leave) / ($overall_total)) * 100), 2) : '0'; ?>%</th>
                            <th><?= $overall_total; ?></th>
                            <th><?= $overall_present; ?></th>
                            <th><?= $overall_leave; ?></th>
                            <th><?= $overall_absent; ?></th>

                            <th colspan="2"><?= lang('total'); ?></th>
                        </tr>
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
            <div class="tab-pane clearfix" id="tab_overall_summary_zone_city">
                <div class="col-md-12 text-center">
                    <?= $event['event_header'] ?>
                    <p><?= date('F d, Y', strtotime($event['event_date'])); ?>,<?= $event['event_location'] ?></p>
                    <p><?= lang('summary') . ' ' . lang('report') ?> : <?= lang('overall'); ?></p>
                </div>
                <table class="table table-bordered table-striped group-table text-center">
                    <thead>
                        <tr>
                            <th><?= lang('percentage'); ?> <?= lang('attendance'); ?></th>
                            <th><?= lang('total'); ?></th>
                            <th><?= lang('present'); ?></th>
                            <th><?= lang('leave'); ?></th>
                            <th><?= lang('absent'); ?></th>
                            <th><?= lang('city'); ?></th>
                            <th><?= lang('zone'); ?></th>
                            <?php if (count($summary) > 1): ?>
                                <th><?= lang('status'); ?></th>
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
                        foreach ($summary as $key => $summary_by_type):
                            $marge_column = true;
                            $overall_total += $summary_by_type['total'];
                            $overall_present += $summary_by_type['present'];
                            $overall_half_leave += $summary_by_type['half_leave'];
                            $overall_leave += $summary_by_type['full_leave'];
                            $overall_absent += $summary_by_type['absent'];
                            foreach ($summary_by_type['zones'] as $zone_summary):
                                $marge_column_zone = true;
                                foreach ($zone_summary['cities'] as $city_summary):
                                    ?>
                                    <tr>
                                        <td><?= ($city_summary['total']) ? round(((($city_summary['present'] + $city_summary['half_leave']) / ($city_summary['total'])) * 100), 2) : '0'; ?>%</td>
                                        <td><?= $city_summary['total']; ?></td>
                                        <td><?= $city_summary['present']; ?></td>
                                        <td><?= $city_summary['full_leave']; ?></td>
                                        <td><?= $city_summary['absent']; ?></td>
                                        <td><?= ($city_summary['details']->city_name != 'direct') ? $city_summary['details']->city_name : ''; ?></td>
                                        <?php if ($marge_column_zone): ?>
                                            <th rowspan="<?= ($zone_summary['no_of_city'] +1); ?>"><?= ($zone_summary['details']->zone_name != 'direct') ? $zone_summary['details']->zone_name : '(' . lang('region') . ')'; ?></th>
                                            <?php
                                            $marge_column_zone = false;
                                        endif;
                                        if (count($summary) > 1):
                                            ?>
                                            <?php if ($marge_column): ?>
                                                <th rowspan="<?= ($summary_by_type['no_of_city'] + 3); ?>"><?= $summary_by_type['event_type_heading']; ?></th>
                                                <?php
                                                $marge_column = false;
                                            endif;
                                        endif;
                                        ?>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="row-seprater2">
                                    <td><?= ($zone_summary['total']) ? round(((($zone_summary['present'] + $zone_summary['half_leave']) / ($zone_summary['total'])) * 100), 2) : '0'; ?>%</td>
                                    <td><?= $zone_summary['total']; ?></td>
                                    <td><?= $zone_summary['present']; ?></td>
                                    <td><?= $zone_summary['full_leave']; ?></td>
                                    <td><?= $zone_summary['absent']; ?></td>
                                    <td><?= lang('total'); ?></td>
                                </tr>        
                            <?php endforeach; ?>
                            <?php if (count($summary) > 1): ?>
                                <tr class="row-seprater">
                                    <td><?= ($summary_by_type['total']) ? round(((($summary_by_type['present'] + $summary_by_type['half_leave']) / ($summary_by_type['total'])) * 100), 2) : '0'; ?>%</td>
                                    <td><?= $summary_by_type['total']; ?></td>
                                    <td><?= $summary_by_type['present']; ?></td>
                                    <td><?= $summary_by_type['full_leave']; ?></td>
                                    <td><?= $summary_by_type['absent']; ?></td>
                                    <td colspan="2"><?= lang('total'); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <tr>
                            <th><?= ($overall_total) ? round(((($overall_present + $overall_half_leave) / ($overall_total)) * 100), 2) : '0'; ?>%</th>
                            <th><?= $overall_total; ?></th>
                            <th><?= $overall_present; ?></th>
                            <th><?= $overall_leave; ?></th>
                            <th><?= $overall_absent; ?></th>
                            <th colspan="3"><?= lang('total'); ?></th>
                            
                        </tr>
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
            <div class="tab-pane clearfix" id="tab_overall_summary_city">
                <div class="col-md-12 text-center">
                    <?= $event['event_header'] ?>
                    <p><?= date('F d, Y', strtotime($event['event_date'])); ?>,<?= $event['event_location'] ?></p>
                    <p><?= lang('summary') . ' ' . lang('report') ?> : <?= lang('overall') . ' ' . lang('city'); ?></p>
                </div>
                <table class="table table-bordered table-striped group-table text-center">
                    <thead>
                        <tr>
                            <th><?= lang('percentage'); ?> <?= lang('attendance'); ?></th>
                            <th><?= lang('total'); ?></th>
                            <th><?= lang('present'); ?></th>
                            <th><?= lang('leave'); ?></th>
                            <th><?= lang('absent'); ?></th>
                            <th><?= lang('city'); ?></th>
                            <?php if (count($summary) > 1): ?>
                                <th><?= lang('status'); ?></th>
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
                        foreach ($summary as $key => $summary_by_type):
                            $marge_column = true;
                            $overall_total += $summary_by_type['total'];
                            $overall_present += $summary_by_type['present'];
                            $overall_half_leave += $summary_by_type['half_leave'];
                            $overall_leave += $summary_by_type['full_leave'];
                            $overall_absent += $summary_by_type['absent'];
                            foreach ($summary_by_type['zones'] as $zone_summary):
                                $marge_column_zone = true;
                                foreach ($zone_summary['cities'] as $city_summary):
                                    ?>
                                    <tr>
                                        <td><?= ($city_summary['total']) ? round(((($city_summary['present'] + $city_summary['half_leave']) / ($city_summary['total'])) * 100), 2) : '0'; ?>%</td>
                                        <td><?= $city_summary['total']; ?></td>
                                        <td><?= $city_summary['present']; ?></td>
                                        <td><?= $city_summary['full_leave']; ?></td>
                                        <td><?= $city_summary['absent']; ?></td>
                                        <td><?= ($city_summary['details']->city_name != 'direct') ? $city_summary['details']->city_name : ''; ?></td>
                                        <?php if (count($summary) > 1):
                                            ?>
                                            <?php if ($marge_column): ?>
                                                <th rowspan="<?= ($summary_by_type['no_of_city'] + 1); ?>"><?= $summary_by_type['event_type_heading']; ?></th>
                                                <?php
                                                $marge_column = false;
                                            endif;
                                        endif;
                                        ?>
                                    </tr>
                                <?php endforeach; ?>       
                            <?php endforeach; ?>
                            <?php if (count($summary) > 1): ?>
                                <tr class="row-seprater">
                                    <td><?= ($summary_by_type['total']) ? round(((($summary_by_type['present'] + $summary_by_type['half_leave']) / ($summary_by_type['total'])) * 100), 2) : '0'; ?>%</td>
                                    <td><?= $summary_by_type['total']; ?></td>
                                    <td><?= $summary_by_type['present']; ?></td>
                                    <td><?= $summary_by_type['full_leave']; ?></td>
                                    <td><?= $summary_by_type['absent']; ?></td>
                                    <td><?= lang('total'); ?></td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <tr>
                            <th><?= ($overall_total) ? round(((($overall_present + $overall_half_leave ) / ($overall_total)) * 100), 2) : '0'; ?>%</th>
                            <th><?= $overall_total; ?></th>
                            <th><?= $overall_present; ?></th>
                            <th><?= $overall_leave; ?></th>
                            <th><?= $overall_absent; ?></th>
                            <th colspan="2"><?= lang('total'); ?></th>
                        </tr>
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