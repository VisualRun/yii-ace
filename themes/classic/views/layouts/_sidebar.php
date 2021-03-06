<div id="sidebar" class="sidebar responsive sidebar-fixed">
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
    </script>

    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <button onclick="location.href='<?php echo Yii::app()->createUrl('task/list') ?>'" class="btn btn-success">
                <i class="ace-icon fa fa-tasks"></i>
            </button>

            <button onclick="location.href='<?php echo Yii::app()->createUrl('user/message') ?>'" onclick class="btn btn-info">
                <i class="ace-icon glyphicon glyphicon-user"></i>
            </button>

            <!-- #section:basics/sidebar.layout.shortcuts -->
            <button onclick="location.href='<?php echo Yii::app()->createUrl('admin/user') ?>'" class="btn btn-warning">
                <i class="ace-icon fa fa-users"></i>
            </button>

            <button onclick="location.href='<?php echo Yii::app()->createUrl('purviewadmin/allpurview') ?>'" class="btn btn-danger">
                <i class="ace-icon fa fa-cogs"></i>
            </button>

            <!-- /section:basics/sidebar.layout.shortcuts -->
        </div>

        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
        </div>
    </div><!-- /.sidebar-shortcuts -->

    <ul class="nav nav-list">
        <?php $menu = Helpers::getUserMenu();?>
        <?php if(!empty($menu)): ?>
        <?php foreach ($menu as $key => $value): ?>
        <li class="<?php if(Yii::app()->controller->id == $key): ?>active <?php if(!empty($value['item'])): ?>open <?php endif;?><?php endif; ?><?php if(!empty($value['item'])): ?>hsub <?php endif;?>">
            <a href="<?php echo $value['href'] ?>" class="<?php if(!empty($value['item'])): ?>dropdown-toggle<?php endif; ?>">
                <i class="menu-icon <?php echo $value['class'] ?>"></i>
                <span class="menu-text"> <?php echo $value['text'] ?> </span>
                <?php if(!empty($value['item'])): ?>
                <b class="arrow fa fa-angle-down"></b>
                <?php endif; ?>
            </a>
            <b class="arrow"></b>
            <?php if(!empty($value['item'])): ?>
                <ul class="submenu">
                <?php foreach ($value['item'] as $key1 => $value1): ?>
                    <li class="<?php if(Yii::app()->controller->id == $key && in_array($this->getAction()->getId(),$value1['action'])): ?>active<?php endif; ?>">
                        <a href="<?php echo $value1['href'] ?>">
                            <i class="menu-icon fa fa-caret-right"></i>
                            <?php echo $value1['text'] ?>
                        </a>

                        <b class="arrow"></b>
                    </li>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
        <?php endif;?>
    </ul><!-- /.nav-list -->

    <!-- #section:basics/sidebar.layout.minimize -->
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>

    <!-- /section:basics/sidebar.layout.minimize -->
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
    </script>
</div>