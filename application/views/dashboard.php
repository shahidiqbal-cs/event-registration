<!-- Small boxes (Stat box) -->
<div class="box box-primary">    
    <div class="box-header with-border">
        <h3 class="box-title"> Fact and figures</h3>
        <div class="box-tools pull-right">
            <button title="" data-toggle="tooltip" data-widget="collapse" class="btn btn-box-tool" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{all_participants}</h3>
                    <p>Total Participants</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="<?= site_url('participant'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <?php if ($attendance): ?>
            <div id="attendance_box" class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{present} / <?= count($attendance); ?></h3>
                        <h4><?= (round($present / count($attendance), 4)) * 100; ?>%</h4>
                        <p>Event Participants</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>

                </div>
            </div><!-- ./col -->
        <?php endif; ?> 
    </div>
</div>
<?php
if ($attendance):
    $this->load->view('registration_page');
endif;
?>