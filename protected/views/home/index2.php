<div class="col-xs-12">
    <div class="row">
        <div class="col-xs-12">
        <?php
            $this->widget('JqGridlist',
              [
                'viewData' => [
                    'start'=>isset($_GET['start'])?$_GET['start']:"",
                    'end'=>isset($_GET['end'])?$_GET['end']:""
                ],
                'model' => 'task',
                'gridSettings' => [
                'caption' => '<strong>推送任务</strong>',
                    'colNames' => [ '任务名称', '类别', '重要', '创建人', '接受人', '状态'],
                    'colModel' => [
                        ['name' => 'name', 'index' => 'name', 'editable' => false],
                        ['name' => 'typeId', 'index' => 'typeId', 'width' => '80', 'editable' => false, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['task_type']]],
                        ['name' => 'imtypeId', 'index' => 'imtypeId', 'width' => '80', 'editable' => false, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['task_important_type']]],
                        ['name' => 'openedId', 'index' => 'openedId', 'editable' => false],
                        ['name' => 'assignedId', 'index' => 'assignedId', 'editable' => false],
                        ['name' => 'status', 'index' => 'status', 'width' => '60', 'editable' => false, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['task_status']]],
                    ],
                    'rowNum' => 10,
                    'rowList' => [10,20,30],
                    'autowidth' => true,

                ],
                'pagerSettings' => [
                    'edit' => false,
                    'add' => false,
                    'del' => false,
                    //'search' => ['multipleSearch' => true]
                    'search' => false,
                ],
                'enableFilterToolbar' => true,
                'resultType'=>'homeindex1',
                'gridType'=>'1',
              ]
            );
        ?>
        </div>
    </div>
    <div class="space-8"></div>
    <div class="row">
        <div class="col-xs-12">
        <?php
            $this->widget('JqGridlist',
              [
                'viewData' => [
                    'start'=>isset($_GET['start'])?$_GET['start']:"",
                    'end'=>isset($_GET['end'])?$_GET['end']:""
                ],
                'model' => 'task',
                'gridSettings' => [
                'caption' => '<strong>承接任务</strong>',
                    'colNames' => [ '任务名称', '类别', '重要', '创建人', '接受人', '状态'],
                    'colModel' => [
                        ['name' => 'name', 'index' => 'name', 'editable' => false],
                        ['name' => 'typeId', 'index' => 'typeId', 'width' => '80', 'editable' => false, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['task_type']]],
                        ['name' => 'imtypeId', 'index' => 'imtypeId', 'width' => '80', 'editable' => false, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['task_important_type']]],
                        ['name' => 'openedId', 'index' => 'openedId', 'editable' => false],
                        ['name' => 'assignedId', 'index' => 'assignedId', 'editable' => false],
                        ['name' => 'status', 'index' => 'status', 'width' => '60', 'editable' => false, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['task_status']]],
                    ],
                    'rowNum' => 10,
                    'rowList' => [10,20,30],
                    'autowidth' => true,

                ],
                'pagerSettings' => [
                    'edit' => false,
                    'add' => false,
                    'del' => false,
                    //'search' => ['multipleSearch' => true]
                    'search' => false,
                ],
                'enableFilterToolbar' => true,
                'resultType'=>'homeindex2',
                'gridType'=>'2',
              ]
            );
        ?>
        </div>
    </div>
    <div class="space-8"></div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 widget-container-col ui-sortable">
            <div class="widget-box">
                <!-- #section:custom/widget-box.header.options -->
                <div class="widget-header widget-header-large">
                    <h4 class="widget-title">你正在执行的任务</h4>
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
        </div>
    </div>
    <div id="dialog-undertake" class="hide">
        <div class="alert alert-info bigger-110">
            <i class="ace-icon fa fa-exclamation-triangle red"></i>
            承接后任务会直接开始，需要在规定的时限内完成！
        </div>
        <div class="space-4"></div>
        <div class="error_info ui-state-error hide"></div>
    </div>
</div>

<script type="text/javascript">
    jQuery(function($) {
        //override dialog's title function to allow for HTML titles
        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function(title) {
                var $title = this.options.title || '&nbsp;'
                if( ("title_html" in this.options) && this.options.title_html == true )
                    title.html($title);
                else title.text($title);
            }
        }));
    })

    function undertake(id){
        $( "#dialog-undertake" ).removeClass('hide').dialog({
            resizable: true,
            modal: true,
            width: 500,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon glyphicon glyphicon-off blue'></i> 承接任务</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 确认承接？",
                    "class" : "btn btn-danger btn-xs",
                    click: function() {

                        $.ajax({
                            type: "POST",
                            url: "<?php echo Yii::app()->createUrl('/task/undertake') ?>",
                            data: "id="+id,
                            dataType : 'json',
                            success: function(msg){
                                if(msg.type == 'success')
                                {
                                    window.location.reload();
                                }else{
                                    $( "#dialog-finished .error_info" ).removeClass('hide').html(msg.info);
                                    return false;
                                }
                            }
                        });
                    }
                }
                ,
                {
                    html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; 取消",
                    "class" : "btn btn-xs",
                    click: function() {
                        $( this ).dialog( "close" );
                    }
                }
            ]
        });
        }
</script>