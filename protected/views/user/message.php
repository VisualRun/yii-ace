<div class="col-xs-12">
<div class="row">
    <?php $this->renderPartial('_message',array('model'=>$model,)); ?>
</div>
<div class="space-10"></div>
<div class="row">
    <div class="control-group col-xs-12 no-padding-left" style="margin-bottom:10px;">
        <div class="col-sm-9" >
            <a href="javascript:void(0)" onclick="setallread();" class="btn btn-white btn-danger btn-round">
                <i class="ace-icon fa fa-inbox orgian2"></i>
                批量设为已读
            </a>
        </div>
    </div>
</div>
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
                        width: 500,
                        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-check green'></i> 查看内容</h4></div>",
                        title_html: true,
                        buttons: [
                            {
                                html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 确认",
                                "class" : "btn btn-danger btn-xs",
                                click: function() {
                                    $( this ).dialog( "close" );
                                    //var page_str = $('.ui-pg-input').val();
                                    var page_str = $('#grid-table').getGridParam('page');
                                    $("#grid-table").jqGrid('setGridParam',{
                                        datatype:'json',
                                        page:page_str
                                    }).trigger("reloadGrid");
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

    function setallread(){

        var rowData = $("#grid-table").jqGrid('getGridParam','selarrrow');

        if(rowData.length)
        {
            var tmp = true;
            for(var i=0;i<rowData.length;i++)
            {
                var checkout= $("#grid-table").jqGrid('getCell',rowData[i],'checkout');
                if(checkout == '已看'){
                    alert("请选择未查看的消息！");
                    tmp = false;
                    break;
                }
            }
        }else{
            alert("请选择消息！");
            return false;
        }
        if(tmp){
            $( "#dialog-check .alert" ).find('span').html("确认批量设为已读？");
            $( "#dialog-check" ).removeClass('hide').dialog({
                resizable: true,
                modal: true,
                width: 500,
                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> 提醒</h4></div>",
                title_html: true,
                buttons: [
                    {
                        html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 确认",
                        "class" : "btn btn-danger btn-xs",
                        click: function() {
                            $.ajax({
                                type: "POST",
                                url: "<?php echo Yii::app()->createUrl('/message/setallread') ?>",
                                dataType : 'json',
                                data : {id:rowData} ,
                                success: function(msg){
                                    if(msg.type == 'success')
                                    {
                                        window.location.reload();
                                    }else{
                                        $( "#dialog-check .error_info" ).removeClass('hide').html(msg.info);
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
    }
</script>