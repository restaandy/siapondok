
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?=APP_NAME; ?> | Login</title>

    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

    <!-- Vendor styles -->
    <link rel="stylesheet" href="<?=base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?=base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="<?=base_url(); ?>assets/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="<?=base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css" />

    <link rel="stylesheet" href="<?=base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="<?=base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="<?=base_url(); ?>assets/styles/style.css">

</head>
<body class="blank">
<?php $this->load->view("layout/splash"); ?>
<div class="color-line"></div>
<div class="login-container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center m-b-md">
                <h3><?=APP_NAME; ?></h3>
                <small>Silakan masukkan username dan password untuk login.</small>
            </div>
            <div class="hpanel">
                <div class="panel-body">
                        <?php echo form_open("login",array("id"=>"loginForm")); ?>
                            <div class="form-group">
                                <label class="control-label" for="username">Username</label>
                                <input type="text" placeholder="Masukkan username anda" required value="" name="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" placeholder="Masukkan kata sandi anda" required value="" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="sbg">Sebagai</label>
                                <select class="form-control" name="sebagai" onchange="action_sebagai(event)" required>
                                    <option value="">-- Sebagai --</option>
                                    <option value="siswa">Siswa</option>
                                    <option value="guru">Guru</option>
                                    <option value="petugas">Petugas</option>
                                    <option value="admin">Administrator</option>
                                </select>
                            </div>
                            <div class="checkbox">
                                <input type="checkbox" class="i-checks" checked>
                                     Remember login
                            </div>
                            <button class="btn btn-success btn-block" name="login" type="submit">Login</button>
                        <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <strong><?=APP_NAME; ?></strong> - Sistem Akademik Amtsilati <br/> Copyright <?=date("Y"); ?> | <?=APP_NAME; ?> <a href="http://andyresta.my.id" target="_blank">Developer Web Aplikasi</a>
        </div>
    </div>
</div>
<script src="<?=base_url(); ?>assets/vendor/jquery/dist/jquery.min.js"></script>
<script src="<?=base_url(); ?>assets/vendor/jquery-ui/jquery-ui.min.js"></script>
<script src="<?=base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?=base_url(); ?>assets/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?=base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>
<script src="<?=base_url(); ?>assets/vendor/iCheck/icheck.min.js"></script>
<script src="<?=base_url(); ?>assets/vendor/sparkline/index.js"></script>
<script src="<?=base_url(); ?>assets/scripts/homer.js"></script>
</body>
</html>