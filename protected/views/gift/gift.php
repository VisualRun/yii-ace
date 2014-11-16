<div class="col-xs-12">
<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-success">
            <strong>我的总积分：</strong>
            <?php echo $user->point ?>
            &nbsp;&nbsp;
            <?php if(!empty($exchanging)): ?>
            <strong>正在进行中的兑换：</strong>
            <?php echo $exchanging_code ?>;
            <strong>对应积分：</strong>
            <?php echo $exchanging_score ?>
            &nbsp;&nbsp;
            <strong>实际可用积分：</strong>
            <?php echo $user->point - $exchanging_score ?>
            <?php endif; ?>
            <br>
        </div>
    </div>
</div>
<div class="row">
    <?php $this->renderPartial('_gift',array('model'=>$model,)); ?>
</div>
<div class="space-10"></div>
<?php
    $this->widget('JqGridlist',
      [
        'viewData' => [
            'start'=>isset($_GET['start'])?$_GET['start']:"",
            'end'=>isset($_GET['end'])?$_GET['end']:""
        ],
        'model' => 'gift',
        'gridSettings' => [
            'caption' => '可兑换物品',
            'colNames' => ['物品编码','物品名称','需要积分','操作'],
            'colModel' => [
                ['name' => 'code', 'index' => 'code', 'editable' => false],
                ['name' => 'name', 'index' => 'name', 'editable' => true],
                ['name' => 'score', 'index' => 'score', 'editable' => true],
                ['name' => 'handle', 'index' => 'id', 'editable' => true],
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
        'resultType'=>'giftapplyresult',
      ]
    );
?>
    <div id="dialog-apply" class="hide">
        <div class="alert alert-info bigger-110">
            <span></span>
        </div>
        <div class="space-4"></div>
        <div class="error_info ui-state-error hide"></div>
    </div>
</div>

<script type="text/javascript">
    $(function(){
        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function(title) {
                var $title = this.options.title || '&nbsp;'
                if( ("title_html" in this.options) && this.options.title_html == true )
                    title.html($title);
                else title.text($title);
            }
        }));
    })
    function apply(id,name)
    {
        
        $( "#dialog-apply .alert" ).find('span').html("申请兑换 "+name+" 吗？");
        $( "#dialog-apply" ).removeClass('hide').dialog({
            resizable: true,
            modal: true,
            width: 500,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-check green'></i> 兑换</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 确认",
                    "class" : "btn btn-danger btn-xs",
                    click: function() {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo Yii::app()->createUrl('/gift/applygift') ?>",
                            data: "id="+id,
                            dataType : 'json',
                            success: function(msg){
                                if(msg.type == 'success')
                                {
                                    window.location.href = '<?php echo Yii::app()->createUrl("gift/exchange") ?>';
                                }else{
                                    $( "#dialog-apply .error_info" ).removeClass('hide').html(msg.info);
                                    return false;
                                }
                            }
                        });
                    }
                },
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