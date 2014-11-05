<div class="col-xs-12">
<div class="row">
    <?php $this->renderPartial('_message',array('model'=>$model,)); ?>
</div>
<div class="space-10"></div>
<?php
    $this->widget('JqGridlist',
      [
        'model' => 'message',
        'gridSettings' => [
            'caption' => '我的消息',
            'colNames' => ['消息ID', '发送人', '消息类别', '关联内容', '消息内容', '是否查看', '创建时间', '操作'],
            'colModel' => [
                ['name' => 'id', 'index' => 'id', 'width' => '40', 'editable' => false],
                ['name' => 'userId', 'index' => 'userId', 'width' => '60', 'editable' => false],
                ['name' => 'typeId', 'index' => 'typeId', 'width' => '60', 'editable' => false, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['message_type']]],
                ['name' => 'linkstr',  'width' => '40'],
                ['name' => 'content', 'index' => 'content', 'editable' => false],
                ['name' => 'checkout', 'index' => 'checkout', 'width' => '60', 'editable' => false],
                ['name' => 'createdTime', 'index' => 'createdTime', 'width' => '60', 'editable' => false, 'formatter'=> "date", 'formatoptions' => ['srcformat'=>'Y-m-d H:i:s','newformat'=>'H:i y/m/d']],
                ['name' => 'hand', 'index' => 'id', 'width' => '40', 'editable' => false],
            ],
            'rowNum' => 10,
            'rowList' => [10,20,30],
            'autowidth' => true,

        ],
        'pagerSettings' => [
            'edit' => false,
            'add' => false,
            'del' => false,
            'search' => false,
            'view' => false,
        ],
        'enableFilterToolbar' => true,
        'resultType'=>'myresult',
      ]
    );
?>
    <div id="dialog-check" class="hide">
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
    function checkmessage(id,type,url)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('/message/checkout') ?>",
            data: "id="+id,
            dataType : 'json',
            success: function(msg){
                if(type == 1)
                {
                     $( "#dialog-check .alert" ).find('span').html(msg.content)
                    $( "#dialog-check" ).removeClass('hide').dialog({
                        resizable: true,
                        modal: true,
                        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-check green'></i> 查看内容</h4></div>",
                        title_html: true,
                        buttons: [
                            {
                                html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 确认",
                                "class" : "btn btn-danger btn-xs",
                                click: function() {
                                    window.location.reload();
                                }
                            }
                        ]
                    });
                }
                else if(type == 2)
                {
                    window.location.href = url;
                }
            }
        });
    }
</script>