<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8" />
        <title>Dashboard - Ace Admin</title>

        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href=".<?php echo Yii::app()->theme->baseUrl;?>/assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href=".<?php echo Yii::app()->theme->baseUrl;?>/assets/css/font-awesome.min.css" />

        <!-- page specific plugin styles -->

        <!-- text fonts -->
        <link rel="stylesheet" href=".<?php echo Yii::app()->theme->baseUrl;?>/assets/css/ace-fonts.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href=".<?php echo Yii::app()->theme->baseUrl;?>/assets/css/ace.min.css" />

        <!--[if lte IE 9]>
            <link rel="stylesheet" href=".<?php echo Yii::app()->theme->baseUrl;?>/assets/css/ace-part2.min.css" />
        <![endif]-->
        <link rel="stylesheet" href=".<?php echo Yii::app()->theme->baseUrl;?>/assets/css/ace-skins.min.css" />
        <link rel="stylesheet" href=".<?php echo Yii::app()->theme->baseUrl;?>/assets/css/ace-rtl.min.css" />

        <!--[if lte IE 9]>
          <link rel="stylesheet" href=".<?php echo Yii::app()->theme->baseUrl;?>/assets/css/ace-ie.min.css" />
        <![endif]-->

        <!-- inline styles related to this page -->

        <!-- ace settings handler -->
        <script src=".<?php echo Yii::app()->theme->baseUrl;?>/assets/js/ace-extra.min.js"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lte IE 8]>
        <script src=".<?php echo Yii::app()->theme->baseUrl;?>/assets/js/html5shiv.js"></script>
        <script src=".<?php echo Yii::app()->theme->baseUrl;?>/assets/js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="no-skin">
        <?php echo $content; ?>
    </body>
</html>