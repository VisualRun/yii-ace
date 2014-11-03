<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<body class="no-skin">
<!-- #section:basics/navbar.layout -->
<?php include "_navbar.php";?>
<!-- /section:basics/navbar.layout -->
<div class="main-container" id="main-container">
    <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
    </script>
    <!-- #section:basics/sidebar -->
    <?php include "_sidebar.php";?>
    <!-- /section:basics/sidebar -->
    <div class="main-content">
        <!-- #section:basics/content.breadcrumbs -->
        <?php include "_breadcrumbs.php";?>
        <!-- /section:basics/content.breadcrumbs -->
        <div class="page-content">
            <!-- #section:settings.box -->
            <!-- /section:settings.box -->
            <div class="page-header">
                <h1>
                    <?php echo $this->pageTitle; ?>
                    <!-- <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        overview &amp; stats
                    </small> -->
                </h1>
            </div><!-- /.page-header -->
            <div class="row">
                <?php echo $content; ?>
            </div>
        </div><!-- /.page-content -->
    </div><!-- /.main-content -->
    <?php include "_footer.php";?>
</div><!-- /.main-container -->
<!-- basic scripts -->

<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/bootstrap.min.js"></script>

<!-- page specific plugin scripts -->
<?php if(!empty(Yii::app()->controller->page_js)): foreach(Yii::app()->controller->page_js as $value): ?>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/<?php echo $value ?>"></script>
<?php endforeach; endif; ?>

<!-- 弹出框 -->
<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery-ui.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/jquery.ui.touch-punch.min.js"></script>

<!-- ace scripts -->
<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/ace.min.js"></script>

<!-- <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl;?>/assets/css/ace.onpage-help.css" />
<link rel="stylesheet" href="../docs/assets/js/themes/sunburst.css" /> -->

<script type="text/javascript"> ace.vars['base'] = '..'; </script>
<!-- <script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/ace/ace.onpage-help.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/rainbow.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/language/generic.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/language/html.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/language/css.js"></script>
<script src="<?php echo Yii::app()->theme->baseUrl;?>/assets/js/language/javascript.js"></script> -->

</body>
<?php $this->endContent(); ?>