<div class="col-xs-12" >

    <!-- PAGE CONTENT BEGINS -->
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'new-form',
    'enableClientValidation' => false,
    'clientOptions' => array(
        'validateOnSubmit' => true,
    ),
    'htmlOptions' => array(
        'name' => 'task_form',
        'enctype' => 'multipart/form-data',
        'class' => 'form-horizontal',
        //'onSubmit' => 'return GetCheckbox()',
    ),
));?>
    <div id ="task_list">
        <div class="form_task" id="form_task" data-myid="0">
        <h3 class="header smaller lighter purple">
        <i class="form_task_close ace-icon glyphicon glyphicon-remove hide" onclick="close_form(this)" ></i>
        添加人事绩效扣分</h3>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">
                兑换人<span class="required">*</span>
            </label>
            <div class="col-sm-5">
                <select class="GiftExchange_applyId" name="GiftExchange[applyId]" >
                    <option value=""> 请选择 </option>
                    <?php $user_arr = CHtml::listData(User::model()->findAll('status = 1 && id != ' . Yii::app()->user->id), 'id', 'account'); ?>
                    <?php foreach ($user_arr as $k => $v): ?>
                    <option  value="<?php echo $k;?>">
                        <?php echo $v;?>
                    </option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">
                兑换物品<span class="required">*</span>
            </label>
            <div class="col-sm-5">
                <select class="GiftExchange_giftId" name="GiftExchange[giftId]" >
                    <option value=""> 请选择 </option>
                    <?php $gift_arr = CHtml::listData(Gift::model()->findAll('status = 1 && num > 0'), 'id', 'name'); ?>
                    <?php foreach ($gift_arr as $k => $v): ?>
                    <option  value="<?php echo $k;?>">
                        <?php echo $v;?>
                    </option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label no-padding-right">
                兑换原因<span class="required">*</span>
            </label>
            <div class="col-sm-5">
                <input type="text" class="GiftExchange_remark" name="GiftExchange[remark]">
            </div>
        </div>
        <div class="form-group hide">
            <label class="col-sm-2 control-label no-padding-right">&nbsp;</label>
            <div class="col-sm-5" class="results"></div>
        </div>
        ·<div class="space-4"></div>
        </div>
        </div>
        <div class="clearfix form-actions">
            <div class="col-md-offset-3 col-md-9">
                <a class="btn btn-info" href="javascript:void(0);" onclick="GetCheckbox()">
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    提 交
                </a>
                &nbsp; &nbsp; &nbsp;
                <button class="btn" type="reset">
                    <i class="ace-icon fa fa-undo bigger-110"></i>
                    重 置
                </button>
            </div>
        </div>
    <?php $this->endWidget();?>
</div>
<div id="dialog-notice" class="hide">
    <div class="alert alert-info">
        <span></span>
    </div>
</div>
<script type="text/javascript">
    jQuery(function($) {
        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function(title) {
                var $title = this.options.title || '&nbsp;'
                if( ("title_html" in this.options) && this.options.title_html == true )
                    title.html($title);
                else title.text($title);
            }
        }));
    })

    function dialog_notice(str){
        $( "#dialog-notice .alert span" ).html(str);
        $( "#dialog-notice" ).removeClass('hide').dialog({
            resizable: false,
            modal: true,
            width: 500,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> 提醒</h4></div>",
            title_html: true,
            buttons: [
                    {
                        html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 确认",
                        "class" : "btn btn-danger btn-xs",
                        click: function() {
                            $( this ).dialog( "close" );
                        }
                    }
                ]
        })
    }

    var GetCheckbox = function (){
        var tmp = true;
        var applyId =  $(".GiftExchange_applyId").find('option:selected').val();
        if(applyId == ''){
            dialog_notice('请选择兑换人！');
            tmp = false;
            return false;
        }

        var giftId =  $(".GiftExchange_giftId").find('option:selected').val();
        if(giftId == ''){
            dialog_notice('请选择兑换物品！');
            tmp == false;
            return false;
        }

        if($(".GiftExchange_remark").val() == ''){
            dialog_notice('请填写兑换原因！');
            tmp =false;
            return false;
        }
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('/admin/checksubtractpoint') ?>",
            data: {'applyId':applyId,'giftId':giftId},
            dataType : 'json',
            success: function(msg){
                if(msg.type == 'success')
                {
                    $("#new-form").submit();
                }else{
                    dialog_notice(msg.info);
                    tmp = false;
                    return false;
                }
            }
        });
        return false;
    }
</script>
