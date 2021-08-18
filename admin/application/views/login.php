<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin | Log in</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.min.css');?>">
        <link rel="stylesheet" href="<?= base_url('assets/FontAwesome/css/font-awesome.min.css'); ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url('assets/dist/css/AdminLTE.min.css');?>">

    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="<?= site_url();?>"><b>Admin</b> Login</a>
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <form action="<?= base_url('login');?>" method="post">
                    <div class="form-group has-feedback <?= (form_error('user_name'))?'has-error':'';?>">
                        <input type="text" class="form-control" placeholder="User Name" name="user_name" value="<?= $this->input->post('admin_user_name');?>" />
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        <label><?php echo form_error('user_name');?></label>
                    </div>
                    <div class="form-group has-feedback <?= (form_error('password'))?'has-error':'';?>">
                        <input type="password" class="form-control" placeholder="Password" name="password" />
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        <label><?php echo form_error('password');?></label>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label style="color:red;">
                                    <?= $this->session->flashdata('error');?>
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                        </div><!-- /.col -->
                    </div>
                </form>

            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->

    </body>
</html>
