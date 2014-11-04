<div id="navbar" class="navbar navbar-default navbar-fixed-top">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-container" id="navbar-container">
        <!-- #section:basics/sidebar.mobile.toggle -->
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler">
            <span class="sr-only">Toggle sidebar</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>
        </button>

        <!-- /section:basics/sidebar.mobile.toggle -->
        <div class="navbar-header pull-left">
            <!-- #section:basics/navbar.layout.brand -->
            <a href="#" class="navbar-brand">
                <small>
                    <i class="fa fa-leaf"></i>
                    <?php echo Yii::app()->name;?>
                </small>
            </a>

            <!-- /section:basics/navbar.layout.brand -->

            <!-- #section:basics/navbar.toggle -->

            <!-- /section:basics/navbar.toggle -->
        </div>

        <!-- #section:basics/navbar.dropdown -->
        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="purple">
                    <a class="dropdown-toggle" href="<?php echo Yii::app()->createUrl('task/myhandletask') ?>">
                        <i class="ace-icon fa fa-tasks "></i>
                        <span id="navbar_task" class="badge badge-grey hide"></span>
                    </a>
                </li>
                <li class="green">
                    <a class="dropdown-toggle" href="<?php echo Yii::app()->createUrl('user/message') ?>">
                        <i class="ace-icon fa fa-envelope "></i>
                        <span id="navbar_message" class="badge badge-success hide"></span>
                    </a>
                </li>

                <!-- #section:basics/navbar.user_menu -->
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="<?php echo Yii::app()->theme->baseUrl;?>/assets/avatars/avatar2.png" alt="avatar2's Photo" />
                        <span class="user-info">
                            <small>欢迎回来,</small>
                            <?php echo Yii::app()->user->getState('account'); ?>
                        </span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="<?php echo $this->createUrl('/user/setting');?>">
                                <i class="ace-icon fa fa-cog"></i>
                               	设置
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo $this->createUrl('/task/myhandletask');?>">
                                <i class="ace-icon fa fa-user"></i>
                                个人任务
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="<?php echo $this->createUrl('/site/logout');?>">
                                <i class="ace-icon fa fa-power-off"></i>
                                退出
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- /section:basics/navbar.user_menu -->
            </ul>
        </div>

        <!-- /section:basics/navbar.dropdown -->
    </div><!-- /.navbar-container -->
</div>
