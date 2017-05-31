<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?=APP_NAME; ?> | <?=$var_title; ?></title>
    <!--<link rel="shortcut icon" type="image/ico" href="favicon.ico" />-->

<?php
    if($gcrud == 1){
        foreach($css_files as $file): ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        <?php endforeach;
    } ?>
    <link rel="stylesheet" href="<?=base_url(); ?>assets/vendor/fontawesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?=base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.css" />
    <link rel="stylesheet" href="<?=base_url(); ?>assets/vendor/animate.css/animate.css" />
    <link rel="stylesheet" href="<?=base_url(); ?>assets/vendor/bootstrap/dist/css/bootstrap.css" />

    <!-- App styles -->
    <link rel="stylesheet" href="<?=base_url(); ?>assets/fonts/pe-icon-7-stroke/css/pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="<?=base_url(); ?>assets/fonts/pe-icon-7-stroke/css/helper.css" />
    <link rel="stylesheet" href="<?=base_url(); ?>assets/styles/style.css">
	
    <style>
        .table-label{
            display: none;
        }
        .footer-tools {
            margin-bottom: 0px;
        }
        .gc-scrolling-left {
            padding-bottom: 0px;
        }
        .options-on-save{
            display: none;
        }
        
        /* BEGIN sidebar menu fix wider */
        #wrapper {
            margin: 0 0 0 250px;
        }
        .fixed-sidebar #menu {
            width: 267px;
        }
        #logo {
            width: 185px;
        }
        .header-link {
            background: #fff;
        }
        /* END sidebar menu fix wider */
        
        .footer{
            padding: 15px 25px;
        }
        
        .btn{
            border-radius: 2px;
        }
        .chosen-single{
            border-radius: 5px;
        }
        
        .select2-container-active .select2-choice, .select2-container-multi.select2-container-active .select2-choices {
            border-color: white;
            outline: none;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px rgba(102, 175, 233, 0.6);
            box-shadow: none;
            -webkit-transition: none;
            -o-transition: none;
            transition: none;
        }
        
        .breadcrumb > li + li:before {
            content: ">";
        }
        
        .content {
            background-image: url(<?=base_url(); ?>assets/images/pattern.png);
        }
        
        .filter-row{
            display: none;
        }
        .cke_dialog_body{
            z-index:0;
        }
       
    </style>
    
    <script src="<?=base_url(); ?>assets/vendor/jquery/dist/jquery.min.js"></script>
    <script src="<?=base_url(); ?>assets/vendor/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?=base_url(); ?>assets/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?=base_url(); ?>assets/vendor/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="<?=base_url(); ?>assets/vendor/jquery-flot/jquery.flot.js"></script>
    <script src="<?=base_url(); ?>assets/vendor/jquery-flot/jquery.flot.resize.js"></script>
    <script src="<?=base_url(); ?>assets/vendor/jquery-flot/jquery.flot.pie.js"></script>
    <script src="<?=base_url(); ?>assets/vendor/flot.curvedlines/curvedLines.js"></script>
    <script src="<?=base_url(); ?>assets/vendor/jquery.flot.spline/index.js"></script>
    <script src="<?=base_url(); ?>assets/vendor/metisMenu/dist/metisMenu.min.js"></script>
    <script src="<?=base_url(); ?>assets/vendor/iCheck/icheck.min.js"></script>
    <script src="<?=base_url(); ?>assets/vendor/peity/jquery.peity.min.js"></script>
    <script src="<?=base_url(); ?>assets/vendor/sparkline/index.js"></script>
    <script src="<?=base_url(); ?>assets/vendor/select2-3.5.2/select2.min.js"></script>
    
    <?php 
    if($gcrud == 1){
        foreach($js_files as $file): ?>
            <script src="<?php echo $file; ?>"></script><?php 
        endforeach;
    } ?>
    <script src="<?=base_url(); ?>assets/scripts/homer.js"></script>
    <script src="<?=base_url(); ?>assets/scripts/charts.js"></script>

</head>
<body class="fixed-navbar fixed-sidebar">

<?php $this->load->view("layout/splash"); ?>

<div id="header">
    <div class="color-line">
    </div>
    <div id="logo" class="light-version">
        <span>
            <?=APP_NAME; ?>
        </span>
    </div>
    <nav role="navigation">
        <div class="header-link hide-menu"><i class="fa fa-bars"></i></div>
        <div class="small-logo">
            <span class="text-primary"><?=APP_NAME; ?></span>
        </div><!--
        <form role="search" class="navbar-form-custom" method="post" action="#">
            <div class="form-group">
                <input type="text" placeholder="Search something special" class="form-control" name="search">
            </div>
        </form>-->
        <div class="navbar-right">
            <ul class="nav navbar-nav no-borders">
                <?php $this->load->view("layout/notification"); ?>
                <?php $this->load->view("layout/big_menu"); ?>
                <li>
                    <a href="#" id="sidebar" class="right-sidebar-toggle">
                        <i class="pe-7s-upload pe-7s-help1 text-info"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="<?=base_url(); ?>logout">
                        <i class="pe-7s-upload pe-rotate-90"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<?php $this->load->view("layout/menu"); ?>
<div id="wrapper">
    <div class="normalheader transition animated fadeIn small-header">
        <div class="hpanel">
            <div class="panel-body">
                <div id="hbreadcrumb" class="pull-right">
                    <ol class="hbreadcrumb breadcrumb"><?php
                        if(isset($var_breadcrumb)){ ?>
                            <li>
                                <a href="<?=base_url(); ?>">
                                    <i class="pe pe-7s-home fa-fw"></i>
                                    Dashboard
                                </a>
                            </li><?php
                            
                            foreach($var_breadcrumb as $b){ ?>
                                <li class="active"><a href="<?=strtolower($b['url']); ?>"><?=$b['title']; ?></a></li><?php
                            } 
                        } ?>
                    </ol>
                </div>
                <h2 class="font-light m-b-xs">
                    <?=$var_title; ?>
                </h2>
                <small><?=$var_subtitle; ?></small>
            </div>
        </div>
    </div>
    <div class="content animate-panel">
        <div class="row">
            <div class="col-lg-12">
				<?php
                    if($gcrud == 1){
                        echo $output;
                        //$this->load->view("module/".$module,$var_other);
                    }else{
                        //print_r($var_other);
                        $this->load->view("module/".$var_module,$var_other);
                    }
                    ?>
            </div>
        </div>
    </div>
    <?php $this->load->view("layout/sidebar"); ?>
    <?php $this->load->view("layout/footer"); ?>

</div>



</body>

</html>