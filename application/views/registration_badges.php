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
                    <div class="col-sm-12 badge-container">
                        <table class="table table-hover to-right urdu-direction registration">
                            <tbody>
                            <tr class="text-center">
                                <th colspan="4"><?= $badge_header; ?></th>
                            </tr>
                            <tr>
                                <th colspan="2" class="text-right"><?= $badge->name; ?></th>
                                <td colspan="2">
                                    <span class="pull-right"><?= $badge->ideology_status; ?></span>
                                    <span class="pull-left reg-number <?= $badge->participant_id < 10 ? 'u-10' : ($badge->participant_id < 99 ? 'u-100' : '') ?>"><?= $badge->participant_id; ?></span>
                                </td>
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

    .badge-container {
        position: relative;
    }

    .badges .signature {
        width: 100%;
        background-image: url('<?= base_url('/assets/signature.jpeg'); ?>');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
    }

    span.reg-number.u-10 {
        padding: 0.5rem 1.5rem
    }
    span.reg-number.u-100 {
        padding: 0.5rem 1rem
    }
    span.reg-number {
        -moz-border-radius: 20px;
        border-radius: 5rem;
        border: 1px solid;
        padding: 0.5rem;
    }


</style>