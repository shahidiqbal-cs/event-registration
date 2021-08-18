<?php
//echo '<pre>';
//print_r($the_participant);
$name = $the_participant['name'];
$father_name = $the_participant['father_name'];
$email = $the_participant['participant_email'];
$number = $the_participant['participant_no'];
$cnic = $the_participant['participant_cnic'];

$administrative_status = $the_participant['administrative_status'];
$ideology_status = $the_participant['ideology_status'];
$propagation_status = $the_participant['propagation_status'];
//$tfw_unit = $the_participant['unit_name'];
$tfw_halqa = $the_participant['halqa_name'];
$tfw_city = $the_participant['city_name'];
?>
<div class="row to-right">
    <div class="col-md-3">
        <!-- About Me Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"> Tfw</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <strong><i class="fa fa-hand-o-left margin-r-5"></i>  City</strong>
                <p class="text-muted"><?= $tfw_city;?> <i class="fa fa-hand-o-down margin-r-5"></i></p>
                <hr>

                <strong><i class="fa fa-hand-o-left margin-r-5"></i>  Halqa</strong>
                <p class="text-muted"><?= $tfw_halqa;?> <i class="fa fa-hand-o-down margin-r-5"></i></p>
                <hr>
                
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
    <div class="col-md-3">
        <!-- About Me Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-bank margin-r-5"></i> Organizational Status</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <strong><i class="fa fa-book margin-r-5"></i>  Ideological Status</strong>
                <p class="text-muted"> <?= $ideology_status; ?></p>
                <hr>
                
                <strong><i class="fa fa-sitemap margin-r-5"></i>  Administrative Status</strong>
                <p class="text-muted"> <?= $administrative_status; ?></p>
                <hr>
                
                <strong><i class="fa fa-share-alt margin-r-5"></i>  Propagation Status</strong>
                <p class="text-muted"> <?= $propagation_status;?></p>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
    <div class="col-md-3">
        <!-- About Me Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"> <i class="fa fa-phone margin-r-5"></i> Contact Details </h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <p><strong><i class="fa fa-mobile margin-r-5"></i> <?= $number; ?></strong></p>
                <p><strong><i class="fa fa-envelope margin-r-5"></i> <?= $email; ?></strong></p>
                <hr>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
    <div class="col-md-3">
        <!-- About Me Box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-info-circle margin-r-5"></i>Personal Details</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <strong><i class="fa fa-pencil margin-r-5"></i> Name</strong>
                <p class="text-muted"><i class="fa fa-child margin-r-5"></i> <?= $name; ?></p>

                <strong><i class="fa fa-pencil margin-r-5"></i>  Father Name</strong>
                <p class="text-muted"><i class="fa fa-male margin-r-5"></i> <?= $father_name; ?></p>
                <hr>

                <strong><i class="fa fa-credit-card margin-r-5"></i> <?= $cnic; ?></strong>

            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div><!-- /.row -->