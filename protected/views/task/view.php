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
            指派到人
        </button>
        <button class="btn btn-white btn-default btn-round">
            <i class="ace-icon fa fa-times red2"></i>
            取消任务
        </button>
        <?php endif; ?>
    </p>
    <?php else: ?>
    <?php endif; ?>
    </div>
</div>

<script type="text/javascript">
    jQuery(function($) {
        $( "#dialog-assigned-btn" ).on('click', function(e) {
            e.preventDefault();

            $( "#dialog-assigned" ).removeClass('hide').dialog({
                resizable: true,
                modal: true,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> 任务指派</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 确认",
                        "class" : "btn btn-danger btn-xs",
                        click: function() {
                            $( this ).dialog( "close" );
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

<div id="dialog-assigned" class="hide">
    <div class="alert alert-info bigger-110">
        指派给<?php echo CHtml::dropDownList('select_assigned','',$assigned_arr)?>
    </div>

    <div class="space-6"></div>

    <p class="bigger-110 bolder center grey">
        <i class="ace-icon fa fa-hand-o-right blue bigger-120"></i>
        Are you sure?
    </p>
</div>