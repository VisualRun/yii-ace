<div class="col-xs-12">
    <?php foreach ($model as $k => $v): ?>
    <?php $submodel = Task::model()->findByPk($v->id);?>
    <?php $file = File::model()->findAll("taskId = $v->id");?>
    <?php $realdeadline = Helpers::realdeadline($submodel);?>
    <h4 class="widget-title lighter smaller">
        <i class="ace-icon fa fa-tasks blue"></i>&nbsp;&nbsp;
        <strong><a title="进入任务详情" href="<?php echo Yii::app()->createUrl('/task/view', array('id' => $v->id));?>" ><?php echo $submodel->name?></a></strong>
    </h4>
    <div class="profile-user-info profile-user-info-striped">
        <div class="profile-info-row">
            <div class="profile-info-name"> 任务编码 </div>

            <div class="profile-info-value">
                <?php echo $submodel->code?>
            </div>
            <div class="profile-info-name"> 状态 </div>

            <div class="profile-info-value">
                <?php echo Yii::app()->params['task_status'][$submodel->status]?>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name"> 任务类别 </div>

            <div class="profile-info-value">
                <?php echo Yii::app()->params['task_type'][$submodel->typeId]?>
            </div>
            <div class="profile-info-name"> 重要类别 </div>

            <div class="profile-info-value">
                <?php echo Yii::app()->params['task_important_type'][$submodel->imtypeId]?>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name"> 创建人 </div>

            <div class="profile-info-value">
                <?php echo $submodel->opened->account?>
            </div>
            <div class="profile-info-name"> 创建时间 </div>

            <div class="profile-info-value">
                <?php echo $submodel->openedDate?>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name"> 奖励积分 </div>

            <div class="profile-info-value">
                <?php echo $submodel->point?>

            </div>
            <div class="profile-info-name"> 最后期限 </div>

            <div class="profile-info-value">
                <?php if ($submodel->deadline_type == 1): ?>
                <?php echo $submodel->deadline;?>&nbsp;(按天)
                <?php elseif ($submodel->deadline_type == 2): ?>
                <?php echo $realdeadline;?>&nbsp;(按小时)
                <?php endif;?>
            </div>
        </div>
        <?php if ($v->assignedId != 0 && $v->status != 4): ?>
        <div class="profile-info-row">
            <div class="profile-info-name"> 指派给 </div>

            <div class="profile-info-value">
                <?php echo $v->assigned->account?>
            </div>
            <div class="profile-info-name"> 指派时间 </div>

            <div class="profile-info-value">
                <?php echo $v->assignedDate?>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name"> 完成时间 </div>

            <div class="profile-info-value">
                <?php echo $v->finishedDate?>
            </div>
            <div class="profile-info-name"> 确认完成时间 </div>

            <div class="profile-info-value">
                <?php echo $v->closedDate?>
            </div>
        </div>
        <?php if ($v->status == 5): ?>
        <div class="profile-info-row">
            <div class="profile-info-name"> 最后得到积分 </div>

            <div class="profile-info-value">
                <?php echo $v->finishedpoint?>
            </div>
            <div class="profile-info-name"></div>

            <div class="profile-info-value">
            </div>
        </div>
        <?php endif;?>
        <?php endif;?>
    </div>
    <div class="space-4"></div>
    <div class="profile-user-info profile-user-info-striped">
        <div class="profile-info-row">
            <div class="profile-info-name"> 任务说明 </div>

            <div class="profile-info-value">
                <?php echo $submodel->desc?>
            </div>
        </div>
    </div>
    <?php if (!empty($file)): ?>
    <div class="space-4"></div>
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> 任务附件 </div>

                <div class="profile-info-value">
                    <?php foreach ($file as $k1· => $v1): ?>
                    <a target="_blank" href="<?php echo $v1->pathname;?>" ><?php echo $v1->title;?></a>&nbsp;&nbsp;
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    <?php endif;?>

    <div class＝"space-4"></div>
    <div class="clearfix form-actions">
    <?php if (Yii::app()->user->id == $v->openedId): ?>
    <p>
        <?php if ($v->status == 2): ?>
        <button class="dialog-closed-btn btn btn-white btn-info btn-round">
            <i class="ace-icon glyphicon glyphicon-off blue "></i>
            确认完成任务
        </button>
        <button class="dialog-return-btn btn btn-white btn-warning btn-round">
            <i class="ace-icon fa fa-reply red"></i>
            退回处理人
        </button>
        <?php endif;?>
        <input type="hidden" name="subid" value="<?php echo $v->id;?>">
    </p>

    <div id="dialog-closed<?php echo $v->id;?>" class="hide">
        <div class="alert alert-info bigger-110">
            <i class="ace-icon fa fa-exclamation-triangle red"></i>
            确认完成任务后会按照任务完成情况给完成人发放积分！
        </div>
        <div class="space-4"></div>
        <div class="error_info ui-state-error hide"></div>
    </div>

    <div id="dialog-return<?php echo $v->id;?>" class="hide">
        <div class="alert alert-info bigger-110">
            <i class="ace-icon fa fa-exclamation-triangle red"></i>
            确定将任务退回处理人吗？
        </div>
        <div class="radio">
            <?php echo CHtml::textField('task_reason', '', array('placeholder' => '退回原因', 'class' => 'col-xs-12', 'maxlength' => '60'))?>
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
        <div class="radio hide delay_div" >
            <?php echo CHtml::textField('delay_value' . $v->id, 1, array('class' => 'spinner'))?>
            <span class="delay_text"></span>
        </div>
        <div class="space-4"></div>
        <div class="error_info ui-state-error hide"></div>
    </div>
    </div>
    <?php endif;?>
    <br><br>
    <?php endforeach;?>

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
            var tmp1 = $(this).parent().parent().next();
            if(tmp_delay == 'day'){
                var tmp_text = "天";
                $(tmp1).removeClass('hide').find('.delay_text').html(tmp_text);
            }else if(tmp_delay == 'hour'){
                var tmp_text = "小时";
                $(tmp1).removeClass('hide').find('.delay_text').html(tmp_text);
            }else if(tmp_delay == 'no'){
                $(tmp1).addClass('hide').find('.delay_text').html('');
            }


        })

        $( ".dialog-closed-btn" ).on('click', function(e) {
            e.preventDefault();

            var this1 = $(this).parent().parent();
            var id = $(this1).find('input[name=subid]').val();

            $("#dialog-closed"+id ).removeClass('hide').dialog({
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
                                url: "<?php echo Yii::app()->createUrl('/task/closed')?>",
                                data: "id="+id,
                                dataType : 'json',
                                success: function(msg){
                                    if(msg.type == 'success')
                                    {
                                        window.location.reload();
                                    }else{
                                        $("#dialog-closed"+id+" .error_info" ).removeClass('hide').html(msg.info);
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

        $( ".dialog-return-btn" ).on('click', function(e) {
            e.preventDefault();

            var this1 = $(this).parent().parent();
            var id = $(this1).find('input[name=subid]').val();

            $("#dialog-return"+id ).removeClass('hide').dialog({
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
                            var reason = $("#dialog-return"+id ).find("input[name=task_reason]").val();
                            if(reason == '')
                            {
                                $( "#dialog-return"+id+" .error_info" ).removeClass('hide').html('退回处理人必须填写原因！');
                                return false;
                            }
                            var delay = $("#dialog-return"+id ).find('input[name=delay]:checked').val();
                            var delay_value = $("#dialog-return"+id ).find("#delay_value"+id).val();
                            if(delay == undefined){
                                delay = 'no';
                                delay_value = 0;
                            }

                            $.ajax({
                                type: "POST",
                                url: "<?php echo Yii::app()->createUrl('/task/return')?>",
                                data: "id="+id+"&reason="+reason+"&delay="+delay+"&delay_value="+delay_value,
                                dataType : 'json',
                                success: function(msg){
                                    if(msg.type == 'success')
                                    {
                                        window.location.reload();
                                    }else{
                                        $("#dialog-return"+id+" .error_info" ).removeClass('hide').html(msg.info);
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