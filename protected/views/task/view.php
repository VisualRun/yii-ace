<div class="col-xs-12">
    <div class="profile-user-info profile-user-info-striped">
        <?php $arr = $model->viewField();?>
        <?php if(!empty($arr)):?>
        <?php foreach ($arr as $key => $value):?>
        <div class="profile-info-row">
            <div class="profile-info-name"> <?php echo $value ?> </div>

            <div class="profile-info-value">
                <?php echo $model->$key ?>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
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
        <button id="dialog-cacel-btn" class="btn btn-white btn-default btn-round">
            <i class="ace-icon fa fa-times red2"></i>
            取消任务
        </button>
        <?php elseif($model->status == 2): ?>
        <button id="dialog-closed-btn" class="btn btn-white btn-info btn-round">
            <i class="ace-icon glyphicon glyphicon-off blue "></i>
            关闭任务
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
            关闭任务后会按照任务完成情况给完成人发放积分！
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

        $( "#dialog-assigned-btn" ).on('click', function(e) {
            e.preventDefault();

            $( "#dialog-assigned" ).removeClass('hide').dialog({
                resizable: false,
                modal: true,
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
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon glyphicon glyphicon-off blue'></i> 关闭任务</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 确认关闭？",
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
    })

</script>