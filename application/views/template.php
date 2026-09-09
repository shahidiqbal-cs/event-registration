<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{title} | Tfw</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?= base_url('assets/admin/bootstrap/css/bootstrap.min.css'); ?>" />
        <!-- Font Awesome -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">-->
        <link rel="stylesheet" href="<?= base_url('assets/admin/FontAwesome/css/font-awesome.min.css'); ?>">
        <!-- Ionicons -->
        <!--<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
        <link rel="stylesheet" href="<?= base_url('assets/admin/ionicons/css/ionicons.min.css'); ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url('assets/admin/dist/css/AdminLTE.min.css'); ?>">
        <!-- DataTables -->
        <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables/dataTables.bootstrap.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datatables/extensions/TableTools/css/dataTables.tableTools.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('assets/admin/dist/css/buttons.dataTables.min.css'); ?>">

        <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.1.0/css/buttons.dataTables.min.css">-->
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?= base_url('assets/admin/dist/css/skins/_all-skins.min.css'); ?>">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/iCheck/flat/blue.css'); ?>">
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/iCheck/all.css'); ?>">
        <!-- Morris chart -->
        <!--<link rel="stylesheet" href="<//?= base_url('assets/admin/plugins/morris/morris.css'); ?>">-->
        <!-- jvectormap -->
        <!--<link rel="stylesheet" href="<? //= base_url('assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css');   ?>">-->
        <!-- Date Picker -->
        <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/datepicker/datepicker3.css'); ?>">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/daterangepicker/daterangepicker-bs3.css'); ?>">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?= base_url('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'); ?>">
        <script type="text/javascript">
            var site_base_url = '<?= base_url(); ?>';
        </script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <?php $this->load->view('header'); ?>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <?php $this->load->view('sidebar'); ?>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        {heading}
                        <small>{heading_desc}</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">{heading}</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <?php if ($this->session->flashdata('success')): ?>
                        <div class="alert alert-success alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
                            <i class="icon fa fa-check"></i> <?= $this->session->flashdata('success'); ?>
                        </div>
                    <?php elseif ($this->session->flashdata('info')): ?>
                        <div class="alert alert-info alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
                            <i class="icon fa fa-info"></i> <?= $this->session->flashdata('info'); ?>
                        </div>
                    <?php elseif ($this->session->flashdata('warning')): ?>
                        <div class="alert alert-warning alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
                            <i class="icon fa fa-warning"></i> <?= $this->session->flashdata('warning'); ?>
                        </div>
                    <?php elseif ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times"></i></button>
                            <i class="icon fa fa-ban"></i> <?= $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>

                    <?php $this->load->view($content); ?>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <footer class="main-footer hidden-print">
            <?php $this->load->view('footer'); ?>
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <?php // $this->load->view('control-bar'); ?>
            </aside><!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div><!-- ./wrapper -->

        <!-- jQuery 2.1.4 -->
        <script src="<?= base_url('assets/admin/plugins/jQuery/jQuery-2.1.4.min.js'); ?>"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
//            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.5 -->
        <script src="<?= base_url('assets/admin/bootstrap/js/bootstrap.min.js'); ?>"></script>
        <!-- Morris.js charts -->
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>-->
        <script src="<?= base_url('assets/admin/live/js/raphael-min.js') ?>"></script>
        <!--<script src="<//?= base_url('assets/admin/plugins/morris/morris.min.js'); ?>"></script>-->
        <!-- Sparkline -->
        <script src="<?= base_url('assets/admin/plugins/sparkline/jquery.sparkline.min.js'); ?>"></script>
        <!-- jvectormap
        <script src="<//?= base_url('assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>
        <script src="<//?= base_url('assets/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js'); ?>"></script>
        -->
        <!-- jQuery Knob Chart -->
        <!--<script src="<//?= base_url('assets/admin/plugins/knob/jquery.knob.js') ?>"></script>-->
        <!-- daterangepicker -->
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>-->
        <script src="<?= base_url('assets/admin/live/js/moment.min.js') ?>"></script>
        <script src="<?= base_url('assets/admin/plugins/daterangepicker/daterangepicker.js'); ?>"></script>
        <!-- datepicker -->
        <script src="<?= base_url('assets/admin/plugins/datepicker/bootstrap-datepicker.js'); ?>"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?= base_url('assets/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'); ?>"></script>

        <!-- Slimscroll -->
        <script src="<?= base_url('assets/admin/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
        <!-- FastClick -->
        <script src="<?= base_url('assets/admin/plugins/fastclick/fastclick.min.js'); ?>"></script>
        <!-- InputMask -->
        <script src="<?= base_url('assets/admin/plugins/input-mask/jquery.inputmask.js'); ?>"></script>
        <script src="<?= base_url('assets/admin/plugins/input-mask/jquery.inputmask.date.extensions.js'); ?>"></script>
        <script src="<?= base_url('assets/admin/plugins/input-mask/jquery.inputmask.extensions.js'); ?>"></script>
        <!-- AdminLTE App -->
        <script src="<?= base_url('assets/admin/dist/js/app.min.js'); ?>"></script>
        <!-- DataTables -->
        <script src="<?= base_url('assets/admin/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
        <script src="<?= base_url('assets/admin/plugins/datatables/dataTables.bootstrap.min.js'); ?>"></script>
        <script src="<?= base_url('assets/admin/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js'); ?>"></script>

        <!--<script src="https://cdn.datatables.net/buttons/1.1.0/js/dataTables.buttons.min.js"></script>-->
<!--        <script src="//cdn.datatables.net/buttons/1.1.0/js/buttons.print.min.js"></script>-->
        <script type="text/javascript" src="<?= base_url('assets/admin/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js'); ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/admin/dist/js/buttons.print.min.js'); ?>"></script>

        <?php if ($this->router->fetch_class() === 'admin' && $this->router->fetch_method() === 'index'): ?>
            <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
            <!--<script src="<? //= base_url('assets/admin/dist/js/pages/dashboard.js');      ?>"></script>-->
            <!-- AdminLTE for demo purposes -->
            <!--<script src="<? //= base_url('assets/admin/dist/js/demo.js');      ?>"></script>-->
        <?php endif; ?>
        <script type="text/javascript" src="<?= base_url('assets/admin/plugins/iCheck/icheck.min.js'); ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/admin/custom.js'); ?>"></script>
    </body>
</html>
