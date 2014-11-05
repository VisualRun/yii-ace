<div class="col-xs-12">
    <!-- <div class="row"> -->
        <?php $realdeadline = Helpers::realdeadline($model);  ?>
        <?php if($model->assignedId == Yii::app()->user->id): ?>
        <?php if($model->status < 2 && time()+86400 > strtotime($realdeadline) && time() < strtotime($realdeadline)): ?>
        <div class="alert alert-info bigger-110">
            <button data-dismiss="alert" class="close" type="button">
                <i class="ace-icon fa fa-times"></i>
            </button>
            <i class="ace-icon fa fa-exclamation-triangle red"></i>
            最后期限将近，请尽快处理
        </div>
        <?php elseif($model->status < 2 && time() > strtotime($realdeadline)): ?>
        <div class="alert alert-info bigger-110">
            <button data-dismiss="alert" class="close" type="button">
                <i class="ace-icon fa fa-times"></i>
            </button>
            <i class="ace-icon fa fa-exclamation-triangle red"></i>
            最后期限已过，请尽快处理
        </div>
        <?php endif; ?>
        <?php endif; ?>
        <div class="alert alert-info bigger-110">
            <button data-dismiss="alert" class="close" type="button">
                <i class="ace-icon fa fa-times"></i>
            </button>
            <i class="ace-icon fa fa-exclamation-triangle red"></i>
            超时没有完成，得到积分会减少，甚至为负数
        </div>
        <div id="recent-box" class="widget-box transparent">
            <div class="widget-header">
                <h4 class="widget-title lighter smaller">
                    <i class="ace-icon fa fa-tasks blue"></i>&nbsp;&nbsp;
                    <strong><?php echO $model->name ?></strong>
                </h4>
                <div class="widget-toolbar no-border">
                    <ul id="recent-tab" class="nav nav-tabs">
                        <li class="active">
                            <a href="#task-tab" data-toggle="tab"> <strong>任务信息</strong></a>
                        </li>

                        <li class="">
                            <a href="#remark-tab" data-toggle="tab"> <strong>备 注</strong> </a>
                        </li>

                        <li class="">
                            <a href="#log-tab" data-toggle="tab"> <strong>操作日志</strong> </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main padding-4">
                    <div class="tab-content padding-8">
                        <div id="task-tab" class="tab-pane active">
                            <div class="profile-user-info profile-user-info-striped">
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 任务编码 </div>

                                    <div class="profile-info-value">
                                        <?php echo $model->code ?>
                                    </div>
                                    <div class="profile-info-name"> 状态 </div>

                                    <div class="profile-info-value">
                                        <?php echo Yii::app()->params['task_status'][$model->status] ?>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 主次类别 </div>

                                    <div class="profile-info-value">
                                        <?php echo Yii::app()->params['task_type'][$model->typeId] ?>
                                    </div>
                                    <div class="profile-info-name"> 重要类别 </div>

                                    <div class="profile-info-value">
                                        <?php echo Yii::app()->params['task_important_type'][$model->imtypeId] ?>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 创建人 </div>

                                    <div class="profile-info-value">
                                        <?php echo $model->opened->account ?>
                                    </div>
                                    <div class="profile-info-name"> 创建时间 </div>

                                    <div class="profile-info-value">
                                        <?php echo $model->openedDate ?>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 奖励积分 </div>

                                    <div class="profile-info-value">
                                        <?php echo $model->point ?>
                                        
                                    </div>
                                    <div class="profile-info-name"> 最后期限 </div>

                                    <div class="profile-info-value">
                                        <?php if($model->deadline_type == 1): ?>
                                        <?php echo $model->deadline; ?>&nbsp;(按天)
                                        <?php elseif($model->deadline_type == 2): ?>
                                        <?php echo $realdeadline; ?>&nbsp;(按小时)
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="space-4"></div>
                            <div class="profile-user-info profile-user-info-striped">
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 任务说明 </div>

                                    <div class="profile-info-value">
                                        <?php echo $model->desc ?>
                                    </div>
                                </div>
                            </div>
			    <?php if(!empty($file)): ?>
			    <div class="space-4"></div>
                            <div class="profile-user-info profile-user-info-striped">
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 任务附件 </div>

                                    <div class="profile-info-value">
                                        <?php foreach($file as $k => $v): ?>
					<a target="_blank" href="<?php echo $v->pathname; ?>" ><?php echo $v->title; ?></a>&nbsp;&nbsp;
                                        <?php endforeach;?>
                                    </div>
                                </div>
                            </div>
			    <?php endif; ?>
                            <div class="space-4"></div>
                            <?php if($model->assignedId != 0 && $model->status != 4): ?>
                            <div class="profile-user-info profile-user-info-striped">
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 指派给 </div>

                                    <div class="profile-info-value">
                                        <?php echo $model->assigned->account ?>
                                    </div>
                                    <div class="profile-info-name"> 指派时间 </div>

                                    <div class="profile-info-value">
                                        <?php echo $model->assignedDate ?>
                                    </div>
                                </div>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 完成时间 </div>

                                    <div class="profile-info-value">
                                        <?php echo $model->finishedDate ?>
                                    </div>
                                    <div class="profile-info-name"> 确认完成时间 </div>

                                    <div class="profile-info-value">
                                        <?php echo $model->canceledDate ?>
                                    </div>
                                </div>
                                <?php if($model->status == 5): ?>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 最后得到积分 </div>

                                    <div class="profile-info-value">
                                        <?php echo $model->finishedpoint ?>
                                    </div>
                                    <div class="profile-info-name"></div>

                                    <div class="profile-info-value">
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div id="remark-tab" class="tab-pane">
                            <div class="profile-user-info profile-user-info-striped">
                                <?php if(!empty($remark)): ?>
                                <?php foreach($remark as $k => $v): ?>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 备注人 </div>

                                    <div class="profile-info-value">
                                        <?php if(!empty($v->user)): ?>
                                        <?php echo $v->user->account ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="profile-info-name">备注内容</div>

                                    <div class="profile-info-value">
                                        <?php echo $v->remark ?>
                                    </div>
                                    <div class="profile-info-name">时间</div>

                                    <div class="profile-info-value">
                                        <?php echo $v->createdTime ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <div class="profile-info-row">
                                    <div class="profile-info-name">&nbsp;&nbsp;</div>
                                    <div class="profile-info-value">没有备注内容</div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div id="log-tab" class="tab-pane">
                            <div class="profile-user-info profile-user-info-striped">
                                <?php if(!empty($log)): ?>
                                <?php foreach($log as $k => $v): ?>
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 操作人 </div>

                                    <div class="profile-info-value">
                                        <?php if(!empty($v->user)): ?>
                                        <?php echo $v->user->account ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="profile-info-name">操作内容</div>

                                    <div class="profile-info-value">
                                        <?php echo $v->content ?>
                                    </div>
                                    <div class="profile-info-name">时间</div>

                                    <div class="profile-info-value">
                                        <?php echo $v->createdTime ?>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <div class="profile-info-row">
                                    <div class="profile-info-name">&nbsp;&nbsp;</div>
                                    <div class="profile-info-value">没有操作日志</div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="space-4"></div>
    <div class="clearfix form-actions">
    <?php if(Yii::app()->user->id == $model->openedId): ?>
    <p>
        <?php if($model->status == 0): ?>
        <button id="dialog-assigned-btn" class="btn btn-white btn-info btn-round">
            <i class="ace-icon fa fa-hand-o-right blue "></i>
            <?php if($model->assignedId): ?>修改指派<?php else:?>指派任务<?php endif; ?>
        </button>
        <button id="dialog-remark-btn" class="btn btn-white btn-info btn-round">
            <i class="ace-icon  fa fa-pencil-square-o orange"></i>
            添加备注
        </button>
        <button id="dialog-cacel-btn" class="btn btn-white btn-warning btn-round">
            <i class="ace-icon fa fa-times red2"></i>
            取消任务
        </button>
        <?php elseif($model->status == 2): ?>
        <button id="dialog-closed-btn" class="btn btn-white btn-info btn-round">
            <i class="ace-icon glyphicon glyphicon-off blue "></i>
            确认完成任务
        </button>
        <button id="dialog-return-btn" class="btn btn-white btn-warning btn-round">
            <i class="ace-icon fa fa-reply red"></i>
            退回处理人
        </button>
        <?php endif; ?>
    </p>
    <?php elseif(Yii::app()->user->id == $model->assignedId): ?>
    <p>
        <?php if($model->status == 0): ?>
        <button id="dialog-start-btn" class="btn btn-white btn-info btn-round">
            <i class="ace-icon glyphicon glyphicon-check green "></i>
            开始任务
        </button>
        <?php elseif($model->status == 1): ?>
        <button id="dialog-remark-btn" class="btn btn-white btn-info btn-round">
            <i class="ace-icon  fa fa-pencil-square-o orange"></i>
            添加备注
        </button>
        <button id="dialog-finished-btn" class="btn btn-white btn-info btn-round">
            <i class="ace-icon glyphicon glyphicon-ok blue "></i>
            完成任务
        </button>
        <?php endif; ?>
    </p>
    <?php endif; ?>
    <?php if(empty($model->assignedId) && $model->status == 0 && Yii::app()->user->id != $model->openedId): ?>
    <p>
        <button id="dialog-undertake-btn" class="btn btn-white btn-info btn-round">
            <i class="ace-icon fa fa-lock green"></i>
            承接任务
        </button>
    </p>
    <?php endif; ?>
    </div>

    <div id="dialog-assigned" class="hide">
        <p class="bigger-110 bolder center grey">
            将任务指派给 <?php echo CHtml::dropDownList('select_assigned','',$assigned_arr)?>
        </p>
        <div class="space-4"></div>
        <div class="error_info ui-state-error hide"></div>
    </div>

    <div id="dialog-cacel" class="hide">
        <div class="alert alert-info bigger-110">
            <i class="ace-icon fa fa-exclamation-triangle red"></i>
            确定取消该任务吗？
        </div>
        <div class="space-4"></div>
        <div class="error_info ui-state-error hide"></div>
    </div>

    <div id="dialog-undertake" class="hide">
        <div class="alert alert-info bigger-110">
            <i class="ace-icon fa fa-exclamation-triangle red"></i>
            承接后任务会直接开始，需要在规定的时限内完成！
        </div>
        <div class="space-4"></div>
        <div class="error_info ui-state-error hide"></div>
    </div>

    <div id="dialog-start" class="hide">
        <div class="alert alert-info bigger-110">
            <i class="ace-icon fa fa-exclamation-triangle red"></i>
            开始任务后，需要在规定的时限内完成！
        </div>
        <div class="space-4"></div>
        <div class="error_info ui-state-error hide"></div>
    </div>

    <div id="dialog-remark" class="hide">
        <p class="bigger-110 bolder center grey">
            备注内容
        </p>
        <p class="bigger-110 bolder center grey">
            <?php echo CHtml::textField('task_remark','',array('class'=>'col-xs-12','maxlength'=>'60'))?>
        </p>
        <div class="space-4"></div>
        <div class="error_info ui-state-error hide"></div>
    </div>

    <div id="dialog-finished" class="hide">
        <div class="alert alert-info bigger-110">
            <i class="ace-icon fa fa-exclamation-triangle red"></i>
            确定完成该任务吗？
        </div>
        <div class="space-4"></div>
        <div class="error_info ui-state-error hide"></div>
    </div>

    <div id="dialog-closed" class="hide">
        <div class="alert alert-info bigger-110">
            <i class="ace-icon fa fa-exclamation-triangle red"></i>
            确认完成任务后会按照任务完成情况给完成人发放积分！
        </div>
        <div class="space-4"></div>
        <div class="error_info ui-state-error hide"></div>
    </div>

    <div id="dialog-return" class="hide">
        <div class="alert alert-info bigger-110">
            <i class="ace-icon fa fa-exclamation-triangle red"></i>
            确定将任务退回处理人吗？
        </div>
        <div class="radio">
            <?php echo CHtml::textField('task_reason','',array('placeholder'=>'退回原因','class'=>'col-xs-12','maxlength'=>'60'))?>
        </div>
        <div class="hr hr-double hr-dotted"></div>
        <div class="radio">
            是否延长最后期限：
            <label>
                <input type="radio" value="day" class="ace" name="delay">
                <span class="lbl"> 延长天数 </span>
            </label>
            <label>
                <input type="radio" value="hour" class="ace" name="delay">
                <span class="lbl"> 延长小时 </span>
            </label>
            <label>
                <input type="radio" value="no" class="ace" name="delay">
                <span class="lbl"> 不延长 </span>
            </label>
        </div>
        <div class="radio hide" id="delay_div" >
            <?php echo CHtml::textField('delay_value',1,array('class'=>'spinner')) ?>
            <span class="delay_text"></span>
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

        var spinner = $( ".spinner" ).spinner({
            create: function( event, ui ) {
                //add custom classes and icons
                $(this)
                .next().addClass('btn btn-success').html('<i class="ace-icon fa fa-plus"></i>')
                .next().addClass('btn btn-danger').html('<i class="ace-icon fa fa-minus"></i>')
                
                //larger buttons on touch devices
                if('touchstart' in document.documentElement) 
                    $(this).closest('.ui-spinner').addClass('ui-spinner-touch');
            },
            min:1
        });

        $( "input[name=delay]" ).on('change', function(e) {
            var tmp_delay = $(this).val();
            if(tmp_delay == 'day'){
                var tmp_text = "天";
                $( "#delay_div" ).removeClass('hide').find('.delay_text').html(tmp_text);
            }else if(tmp_delay == 'hour'){
                var tmp_text = "小时";
                $( "#delay_div" ).removeClass('hide').find('.delay_text').html(tmp_text);
            }else if(tmp_delay == 'no'){
                $( "#delay_div" ).addClass('hide').find('.delay_text').html('');
            }

            
        })

        $( "#dialog-assigned-btn" ).on('click', function(e) {
            e.preventDefault();

            $( "#dialog-assigned" ).removeClass('hide').dialog({
                resizable: false,
                modal: true,
                width: 500,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-hand-o-right blue'></i> 指派任务</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 确认指派？",
                        "class" : "btn btn-danger btn-xs",
                        click: function() {
                            var assignedid = $("#select_assigned option:selected").val();
                            if(assignedid == "" || assignedid == undefined)
                            {
                                $( "#dialog-assigned .error_info" ).removeClass('hide').html('请选择人员！');
                                return false;
                            }
                            $.ajax({
                                type: "POST",
                                url: "<?php echo Yii::app()->createUrl('/task/assigned') ?>",
                                data: "id=<?php echo $model->id ?>&assignedid="+assignedid,
                                dataType : 'json',
                                success: function(msg){
                                    if(msg.type == 'success')
                                    {
                                        window.location.reload();
                                    }else{
                                        $( "#dialog-assigned .error_info" ).removeClass('hide').html(msg.info);
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
        });

        $( "#dialog-cacel-btn" ).on('click', function(e) {
            e.preventDefault();

            $( "#dialog-cacel" ).removeClass('hide').dialog({
                resizable: true,
                modal: true,
                width: 500,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> 取消任务</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 确认取消？",
                        "class" : "btn btn-danger btn-xs",
                        click: function() {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo Yii::app()->createUrl('/task/cacel') ?>",
                                data: "id=<?php echo $model->id ?>",
                                dataType : 'json',
                                success: function(msg){
                                    if(msg.type == 'success')
                                    {
                                        window.location.reload();
                                    }else{
                                        $( "#dialog-cacel .error_info" ).removeClass('hide').html(msg.info);
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
        });

        $( "#dialog-start-btn" ).on('click', function(e) {
            e.preventDefault();

            $( "#dialog-start" ).removeClass('hide').dialog({
                resizable: true,
                modal: true,
                width: 500,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon glyphicon glyphicon-check green'></i> 开始任务</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 确认开始？",
                        "class" : "btn btn-danger btn-xs",
                        click: function() {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo Yii::app()->createUrl('/task/start') ?>",
                                data: "id=<?php echo $model->id ?>",
                                dataType : 'json',
                                success: function(msg){
                                    if(msg.type == 'success')
                                    {
                                        window.location.reload();
                                    }else{
                                        $( "#dialog-cacel .error_info" ).removeClass('hide').html(msg.info);
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
        });

        $( "#dialog-remark-btn" ).on('click', function(e) {
            e.preventDefault();

            $( "#dialog-remark" ).removeClass('hide').dialog({
                resizable: true,
                modal: true,
                width: 500,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-pencil-square-o orange'></i> 添加备注</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 添加备注？",
                        "class" : "btn btn-danger btn-xs",
                        click: function() {
                            var task_remark = $("#task_remark").val();
                            if(task_remark == "" || task_remark == undefined)
                            {
                                $( "#dialog-remark .error_info" ).removeClass('hide').html('请填写备注！');
                                return false;
                            }
                            $.ajax({
                                type: "POST",
                                url: "<?php echo Yii::app()->createUrl('/task/remark') ?>",
                                data: "id=<?php echo $model->id ?>&remark="+task_remark,
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
        });

        $( "#dialog-finished-btn" ).on('click', function(e) {
            e.preventDefault();

            $( "#dialog-finished" ).removeClass('hide').dialog({
                resizable: true,
                modal: true,
                width: 500,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon glyphicon glyphicon-ok blue'></i> 完成任务</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 确认完成？",
                        "class" : "btn btn-danger btn-xs",
                        click: function() {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo Yii::app()->createUrl('/task/finished') ?>",
                                data: "id=<?php echo $model->id ?>",
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
        });

        $( "#dialog-closed-btn" ).on('click', function(e) {
            e.preventDefault();

            $( "#dialog-closed" ).removeClass('hide').dialog({
                resizable: true,
                modal: true,
                width: 500,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon glyphicon glyphicon-off blue'></i> 确认完成任务</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 确认确认完成？",
                        "class" : "btn btn-danger btn-xs",
                        click: function() {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo Yii::app()->createUrl('/task/closed') ?>",
                                data: "id=<?php echo $model->id ?>",
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
        });

        $( "#dialog-undertake-btn" ).on('click', function(e) {
            e.preventDefault();

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
                                data: "id=<?php echo $model->id ?>",
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
        });

        $( "#dialog-return-btn" ).on('click', function(e) {
            e.preventDefault();

            $( "#dialog-return" ).removeClass('hide').dialog({
                resizable: true,
                modal: true,
                width: 500,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-reply red'></i> 退回任务</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 确认退回？",
                        "class" : "btn btn-danger btn-xs",
                        click: function() {
                            var reason = $("input[name=task_reason]").val();
                            if(reason == '')
                            {
                                $( "#dialog-return .error_info" ).removeClass('hide').html('退回处理人必须填写原因！');
                                return false;
                            }
                            var delay = $('input[name=delay]:checked').val();
                            var delay_value = $("#delay_value").val();
                            if(delay == undefined){
                                delay = 'no';
                                delay_value = 0;
                            }

                            $.ajax({
                                type: "POST",
                                url: "<?php echo Yii::app()->createUrl('/task/return') ?>",
                                data: "id=<?php echo $model->id ?>&reason="+reason+"&delay="+delay+"&delay_value="+delay_value,
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
        });
    })

</script>
