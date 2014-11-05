<div class="col-xs-12">
    <!-- 提示信息 -->
    <!-- <div class="row">
    <div class="alert alert-block alert-success">
        <button data-dismiss="alert" class="close" type="button">
            <i class="ace-icon fa fa-times"></i>
        </button>

        <i class="ace-icon fa fa-check green"></i>

        Welcome to
        <strong class="green">
            Ace
            <small>(v1.3)</small>
        </strong>,
the lightweight, feature-rich and easy to use admin template.
    </div>
    </div> -->
    <div class="space-4"></div>
    <!-- 提示结束 -->
    <div class="row">
        <div class="col-xs-12 col-sm-6 widget-container-col ui-sortable">
            <div class="widget-box">
                <!-- #section:custom/widget-box.header.options -->
                <div class="widget-header widget-header-large">
                    <h4 class="widget-title">最新动态</h4>

                    <div class="widget-toolbar">

                        <a href="#" data-action="collapse">
                            <i class="ace-icon fa fa-chevron-up"></i>
                        </a>

                    </div>
                </div>

                <!-- /section:custom/widget-box.header.options -->
                <div class="widget-body">
                    <div class="widget-body-inner" style="display: block;">
                        <div class="widget-main">
                            <?php foreach($syslog as $k =>$v): ?>
                            <div class="row">
                                <div class="col-xs-2">
                                <span class="label arrowed-in"><?php echo Yii::app()->params['log_type'][$v->typeId] ?></span>
                                </div>
                                <div class="col-xs-7">
                                    <?php echo $v->content ?>
                                </div>
                                <div class="col-xs-3">
                                    <?php echo date('m月d日 H:i',strtotime($v->createdTime)) ?>
                                </div>
                            </div>
                            <div class="space-8"></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 widget-container-col ui-sortable">
            <div class="widget-box">
                <!-- #section:custom/widget-box.header.options -->
                <div class="widget-header widget-header-large">
                    <h4 class="widget-title">个人待处理任务</h4>
                    <div class="widget-toolbar">
                        <div class="widget-menu">
                            <a href="#" data-action="settings" data-toggle="dropdown">
                                <i class="ace-icon fa fa-bars"></i>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-right dropdown-light-blue dropdown-caret dropdown-closer">
                                <li>
                                    <a href="<?php echo Yii::app()->createUrl('/task/myhandletask') ?>">查看所有</a>
                                </li>
                            </ul>
                        </div>

                        <a href="#" data-action="fullscreen" class="orange2">
                            <i class="ace-icon fa fa-expand"></i>
                        </a>

                        <a href="#" data-action="collapse">
                            <i class="ace-icon fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <!-- /section:custom/widget-box.header.options -->
                <div class="widget-body">
                    <div class="widget-body-inner" style="display: block;">
                        <div class="widget-main">
                            <?php if(!empty($myhandletask)): ?>
                            <?php foreach($myhandletask as $k =>$v): ?>
                            <div class="row">
                                <div class="col-xs-2">
                                <span class="label <?php if($v->imtypeId == 3): ?>label-danger<?php elseif($v->imtypeId == 2): ?>label-warning<?php elseif($v->imtypeId == 1): ?>label-grey<?php elseif($v->imtypeId == 0): ?>label-light<?php endif; ?> arrowed-in"><?php echo Yii::app()->params['task_important_type'][$v->imtypeId] ?></span>
                                </div>
                                <div class="col-xs-6">
                                <a href="<?php echo Yii::app()->createUrl('task/view',array('id'=>$v->id)) ?>">
                                    <?php echo $v->name ?>
                                </a>
                                </div>
                                <div class="col-xs-2">
                                    <?php echo $v->point ?> 积分
                                </div>
                                <div class="col-xs-2">
                                <span class="label label-info arrowed-in-right"><?php echo Yii::app()->params['task_status'][$v->status] ?></span>
                                </div>
                            </div>
                            <div class="space-8"></div>
                            <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    你暂时没有需要处理的任务，看看下面那么没有指派人的任务吧！
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space"></div>
            <div class="widget-box">
                <!-- #section:custom/widget-box.header.options -->
                <div class="widget-header widget-header-large">
                    <h4 class="widget-title">系统待承接的任务</h4>
                    <div class="widget-toolbar">
                        <div class="widget-menu">
                            <a href="#" data-action="settings" data-toggle="dropdown">
                                <i class="ace-icon fa fa-bars"></i>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-right dropdown-light-blue dropdown-caret dropdown-closer">
                                <li>
                                    <a href="<?php echo Yii::app()->createUrl('/task/list',array('assignedId'=>0)) ?>">查看所有待接受任务</a>
                                </li>

                                <li>
                                    <a href="<?php echo Yii::app()->createUrl('/task/list') ?>">查看所有任务</a>
                                </li>
                            </ul>
                        </div>

                        <a href="#" data-action="fullscreen" class="orange2">
                            <i class="ace-icon fa fa-expand"></i>
                        </a>

                        <a href="#" data-action="collapse">
                            <i class="ace-icon fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <!-- /section:custom/widget-box.header.options -->
                <div class="widget-body">
                    <div class="widget-body-inner" style="display: block;">
                        <div class="widget-main">
                            <?php if(!empty($noassigned)): ?>
                            <?php foreach($noassigned as $k =>$v): ?>
                            <div class="row">
                                <div class="col-xs-2">
                                <span class="label <?php if($v->imtypeId == 3): ?>label-danger<?php elseif($v->imtypeId == 2): ?>label-warning<?php elseif($v->imtypeId == 1): ?>label-grey<?php elseif($v->imtypeId == 0): ?>label-light<?php endif; ?> arrowed-in"><?php echo Yii::app()->params['task_important_type'][$v->imtypeId] ?></span>
                                </div>
                                <div class="col-xs-6">
                                <a href="<?php echo Yii::app()->createUrl('task/view',array('id'=>$v->id)) ?>">
                                    <?php echo $v->name ?>
                                </a>
                                </div>
                                <div class="col-xs-2">
                                    <?php echo $v->point ?> 积分
                                </div>
                                <div class="col-xs-2">
                                <span class="label label-info arrowed-in-right"><?php echo Yii::app()->params['task_status'][$v->status] ?></span>
                                </div>
                            </div>
                            <div class="space-8"></div>
                            <?php endforeach; ?>
                            <?php else: ?>
                                <div class="alert alert-info">
                                    暂时还没有人发布任务，耐心等待一下吧！
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>