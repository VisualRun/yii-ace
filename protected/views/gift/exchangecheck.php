<div class="col-xs-12">
<div class="row">
    <?php $this->renderPartial('_exchangecheck',array('model'=>$model,)); ?>
</div>
<div class="space-10"></div>
<?php
    $this->widget('JqGridlist',
      [
        'viewData' => [
            'start'=>isset($_GET['start'])?$_GET['start']:"",
            'end'=>isset($_GET['end'])?$_GET['end']:""
        ],
        'model' => 'giftexchange',
        'gridSettings' => [
            'caption' => '个人兑换记录',
            'colNames' => ['记录编码','物品名称','兑换积分','状态','操作'],
            'colModel' => [
                ['name' => 'code', 'index' => 'code', 'editable' => false],
                ['name' => 'giftId', 'index' => 'giftId', 'editable' => true],
                ['name' => 'score', 'index' => 'score', 'editable' => true],
                ['name' => 'status', 'index' => 'status', 'editable' => true],
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
        'resultType'=>'exchangecheckresult',
      ]
    );
?>
    <div id="dialog-checkok" class="hide">
        <div class="alert alert-info bigger-110">
            <span></span>
        </div>
        <div class="space-4"></div>
        <div class="error_info ui-state-error hide"></div>
    </div>

    <div id="dialog-checknot" class="hide">
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
    function checkok(id,name,code)
    {
        
        $( "#dialog-checkok .alert" ).find('span').html("确定通过 "+code+" 的 "+name+" 兑换申请吗？");
        $( "#dialog-checkok" ).removeClass('hide').dialog({
            resizable: true,
            modal: true,
            width: 500,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-check green'></i> 审核通过</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 确认",
                    "class" : "btn btn-danger btn-xs",
                    click: function() {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo Yii::app()->createUrl('/gift/checkok') ?>",
                            data: "id="+id,
                            dataType : 'json',
                            success: function(msg){
                                if(msg.type == 'success')
                                {
                                    window.location.reload();
                                    // $( this ).dialog( "close" );
                                    // //var page_str = $('.ui-pg-input').val();
                                    // var page_str = $('#grid-table').getGridParam('page');
                                    // $("#grid-table").jqGrid('setGridParam',{
                                    //     datatype:'json',
                                    //     page:page_str
                                    // }).trigger("reloadGrid");
                                }else{
                                    $( "#dialog-checkok .error_info" ).removeClass('hide').html(msg.info);
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

     function checknot(id,name,code)
    {
        
        $( "#dialog-checknot .alert" ).find('span').html("确定不通过 "+code+" 的 "+name+" 兑换申请吗？");
        $( "#dialog-checknot" ).removeClass('hide').dialog({
            resizable: true,
            modal: true,
            width: 500,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> 审核不通过</h4></div>",
            title_html: true,
            buttons: [
                {
                    html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 确认",
                    "class" : "btn btn-danger btn-xs",
                    click: function() {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo Yii::app()->createUrl('/gift/checknot') ?>",
                            data: "id="+id,
                            dataType : 'json',
                            success: function(msg){
                                if(msg.type == 'success')
                                {
                                    window.location.reload();
                                    // $( this ).dialog( "close" );
                                    // //var page_str = $('.ui-pg-input').val();
                                    // var page_str = $('#grid-table').getGridParam('page');
                                    // $("#grid-table").jqGrid('setGridParam',{
                                    //     datatype:'json',
                                    //     page:page_str
                                    // }).trigger("reloadGrid");
                                }else{
                                    $( "#dialog-checknot .error_info" ).removeClass('hide').html(msg.info);
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