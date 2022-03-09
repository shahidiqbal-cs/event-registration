<div class="tab-pane clearfix active" id="tab_overall_summary_city_no_status">
    <div class="col-md-12 text-center">
        <?= $event['event_header'] ?>
        <p><?= date('F d, Y', strtotime($event['event_date'])); ?>,<?= $event['event_location'] ?></p>
        <p><?= lang('summary') . ' ' . lang('report') ?> : <?= lang('overall') . ' ' . lang('city'); ?></p>
    </div>
    <?php
    $totals = [
        'absent' => 0,
        'present' => 0,
        'full_leave' => 0,
        'total' => 0,
    ];
    $summaryByCities = [];
    foreach ($summary as $statusSummary) {
        foreach ($statusSummary['zones'] as $zonesSummary) {
            foreach ($zonesSummary['cities'] as $citiesSummary) {
                if (!array_key_exists($citiesSummary['details']->city_id, $summaryByCities)) {
                    $row = [
                        'name' => $citiesSummary['details']->city_name,
                    ];
                    foreach ($totals as $totalKey => $value) {
                        $row[$totalKey] = 0;
                    }
                    $summaryByCities[$citiesSummary['details']->city_id] = $row;
                }
                foreach ($totals as $key => $value) {
                    $summaryByCities[$citiesSummary['details']->city_id][$key] += $citiesSummary[$key];
                    $totals[$key] += $citiesSummary[$key];
                }
            }
        }
    }
    ?>
    <table class="table table-bordered table-striped group-table text-center">
        <thead>
        <tr>
            <th><?= lang('percentage'); ?> <?= lang('attendance'); ?></th>
            <th><?= lang('total'); ?></th>
            <th><?= lang('present'); ?></th>
            <th><?= lang('leave'); ?></th>
            <th><?= lang('absent'); ?></th>
            <th><?= lang('city'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($summaryByCities as $citySummary) {
            ?>
            <tr>
                <td><?= ($citySummary['total']) ? round((($citySummary['present'] / $citySummary['total']) * 100), 2) : '0'; ?>%</td>
                <td><?= $citySummary['total']; ?></td>
                <td><?= $citySummary['present']; ?></td>
                <td><?= $citySummary['full_leave']; ?></td>
                <td><?= $citySummary['absent']; ?></td>
                <td><?= $citySummary['name']; ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
        <tfoot>
        <tr class="row-seprater">
            <th><?= $totals['total'] ? round((($totals['present'] / $totals['total']) * 100), 2) : '0'; ?>%</th>
            <th><?= $totals['total']; ?></th>
            <th><?= $totals['present']; ?></th>
            <th><?= $totals['full_leave']; ?></th>
            <th><?= $totals['absent']; ?></th>
            <th><?= lang('total'); ?></th>
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