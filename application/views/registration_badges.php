<div class="box box-primary">    
    <div class="box-header with-border hidden-print">
        <h3 class="box-title"><?= ($badges) ? count($badges) . ' Badges created' : ''; ?></h3>
        <div class="box-tools pull-right">
            <button id="" class="btn btn-default" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
        </div>
    </div>
    <div class="box-body" id="print_badges">
        <?php if ($badges): ?>

            <?php foreach ($badges as $key => $badge): ?>
                <?php if (($key) % 2 == 0): ?>
                    <div class="col-sm-12 <?= ($key !=0 && $key % 10 == 0) ? ' page-break' : ''; ?>">
                    <?php endif; ?>
                    <div class="pull-left badges">
                        <div class="col-sm-12">
                            <table class="table table-hover urdu-direction registration">
                                <tbody>
                                    <tr>
                                        <th colspan="2"><?= $badge_header; ?></th>
                                    </tr>
                                    <tr>
                                        <td><?= lang('branch') . ' : ' . $badge->city_name; ?></td>
                                        <td><?= lang('name') . ' : ' . $badge->name; ?></td>
                                    </tr>
                                    <tr>
                                        <td><?= lang('registration') . ' : ' . $badge->participant_id; ?></td>
                                        <td><?= lang('status') . ' : ' . $badge->ideology_status; ?></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2"><?= $badge_footer; ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <?php if (($key) % 2 != 0): ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
                No Result found.
            </div>
        <?php endif; ?>
    </div> 
    <div class="box-footer hidden-print">
        Total found: <?= ($badges) ? count($badges) : '0'; ?>
    </div><!-- /.box-footer -->
</div>