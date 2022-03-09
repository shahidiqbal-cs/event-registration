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
                    <div class="col-sm-12 <?= ($key != 0 && $key % 10 == 0) ? ' page-break' : ''; ?>">
                <?php endif; ?>
                <div class="pull-left badges">
                    <div class="col-sm-12 demo-content">
                        <table class="table table-hover to-right registration text-center">
                            <tbody>
                            <tr>
                                <th colspan="4"><?= $badge_header; ?></th>
                            </tr>
                            <tr>
                                <th colspan="2"><?= $badge->name; ?></th>
                                <td><?= $badge->ideology_status; ?></td>
                                <td><?= $badge->participant_id; ?></td>
                            </tr>
                            <tr>
                                <td colspan="2"><?= lang('branch') . ' : ' . $badge->city_name; ?></td>
                                <td><?= $badge_footer; ?></td>
                                <td class="signature"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if (($key) % 2 != 0): ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i>
                </button>
                No Result found.
            </div>
        <?php endif; ?>
    </div>
    <div class="box-footer hidden-print">
        Total found: <?= ($badges) ? count($badges) : '0'; ?>
    </div><!-- /.box-footer -->
</div>
<style>
    .badges table {
        table-layout: fixed;
    }


    .badges {
        position: relative;
    }

    .badges:before {
        content: ' ';
        display: block;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        opacity: 0.1;
        background-image: url('/assets/tanzeem-logo.jpeg');
        background-repeat: no-repeat;
        background-position: 50% 0;
        background-size: contain;
    }

    .demo-content {
        position: relative;
    }
    .badges .signature {
        width: 100%;
        background-image: url('<?= base_url('/assets/signature.jpeg'); ?>');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }

</style>