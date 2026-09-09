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
                    <div class="col-sm-12 badge-container rtl" >
                        <p class="text-center badge-header"><?= $badge_header ?></p>
                        <div style="position: relative">
                            <p class="badge-name text-center mb-0"><?= $badge->name; ?></p>
                            <span
                                  class="pull-left reg-number <?= $badge->participant_id < 10 ? 'u-10' : ($badge->participant_id < 99 ? 'u-100' : '') ?>"><?= $badge->participant_id; ?></span>
                        </div>

                        <div class="row text-center">
                            <div class="col-sm-6"><?= lang('branch') . ' : ' . $badge->city_name; ?></div>
                            <div class="col-sm-6"><?= $badge->ideology_status; ?></div>
                        </div>
                        <div class="row signature-row">
                            <div class="col-sm-3 signature"></div>
                            <div class="col-sm-9 text-left"><?= $badge_footer; ?></div>
                        </div>
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
.rtl {
    direction: rtl;
}

.badge-header {
    min-width: max-content;
    font-size: 1.8rem;
}

.pb-0 {
    padding-bottom: 0;
}

.mb-0 {
    margin-bottom: 0;
}

.badges {
    position: relative;
    -webkit-print-color-adjust: exact;
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
    background-image: url('/assets/logo.jpg') !important;
    background-repeat: no-repeat !important;;
    background-position: 50% 0 !important;;
    background-size: contain !important;
    z-index: 999;
}

.badge-container {
    position: relative;
}

.badges .signature {
    height: 100%;
    content: url('/assets/signature.jpeg');
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
}

.signature-row {
padding-top: 2rem;
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
    position: absolute;
    top: 25%;
    left: 0
}

.badge-name {
    font-size: 5rem;
}

@media print {
    .badge-container .col-sm-3,
    .badge-container .col-sm-6,
    .badge-container .col-sm-9,
    .badge-container .col-sm-12 {
        float: left;
    }

    .badge-container .col-sm-12 {
        width: 100%;
    }

    .badge-container .col-sm-11 {
        width: 91.66666667%;
    }

    .badge-container .col-sm-10 {
        width: 83.33333333%;
    }

    .badge-container .col-sm-9 {
        width: 75%;
    }

    .badge-container .col-sm-8 {
        width: 66.66666667%;
    }

    .badge-container .col-sm-7 {
        width: 58.33333333%;
    }

    .badge-container .col-sm-6 {
        width: 50%;
    }

    .badge-container .col-sm-5 {
        width: 41.66666667%;
    }

    .badge-container .col-sm-4 {
        width: 33.33333333%;
    }

    .badge-container .col-sm-3 {
        width: 25%;
    }

    .badge-container .col-sm-2 {
        width: 16.66666667%;
    }

    .badge-container .col-sm-1 {
        width: 8.33333333%;
    }
}
</style>