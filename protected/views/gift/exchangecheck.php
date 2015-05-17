<div class="col-xs-12">
<div class="row">
    <?php $this->renderPartial('_exchangecheck',array('model'=>$model,)); ?>
</div>
<div class="space-10"></div>
<div class="row">
    <div class="control-group col-xs-12 no-padding-left" style="margin-bottom:10px;">
        <div class="col-sm-9" >
            <a href="javascript:void(0)" onclick="setallok();" class="btn btn-white btn-default btn-round">
                <i class="ace-icon fa fa-check-square-o"></i>
                批量审核通过
            </a>
            <a href="javascript:void(0)" onclick="setallnot();" class="btn btn-white btn-warning btn-round">
                <i class="ace-icon fa fa-exclamation-triangle"></i>
                批量审核不通过
            </a>
        </div>
    </div>
</div>
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
            'colNames' => ['记录编码','兑换人','物品名称','兑换积分','状态','备注','申请时间','操作'],
            'colModel' => [
                ['name' => 'code', 'index' => 'code', 'editable' => false],
                ['name' => 'applyId', 'index' => 'applyId', 'editable' => true],
                ['name' => 'giftId', 'index' => 'giftId', 'editable' => true],
                ['name' => 'score', 'index' => 'score', 'editable' => true],
                ['name' => 'status', 'index' => 'status', 'editable' => true],
                ['name' => 'remark', 'index' => 'remark', 'editable' => false],
                ['name' => 'applyDate', 'index' => 'applyDate', 'editable' => false, 'formatter'=> "date", 'formatoptions' => ['srcformat'=>'Y-m-d H:i:s','newformat'=>'y/m/d H:i']],
                ['name' => 'handle', 'index' => 'id', 'width' => '180', 'editable' => true],
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

    function setallok(){

        var rowData = $("#grid-table").jqGrid('getGridParam','selarrrow');

        if(rowData.length)
        {
            var tmp = true;
            for(var i=0;i<rowData.length;i++)
            {
                var status= $("#grid-table").jqGrid('getCell',rowData[i],'status');
                if(status == '审核不过' || status == '兑换成功'){
                    alert("请选择新申请的兑换记录！");
                    tmp = false;
                    break;
                }
            }
        }else{
            alert("请选择兑换记录！");
            return false;
        }
        if(tmp){
            $( "#dialog-checkok .alert" ).find('span').html("确认批量审核通过？");
            $( "#dialog-checkok" ).removeClass('hide').dialog({
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
                                url: "<?php echo Yii::app()->createUrl('/gift/checkallok') ?>",
                                dataType : 'json',
                                data : {id:rowData} ,
                                success: function(msg){
                                    if(msg.type == 'success')
                                    {
                                        window.location.reload();
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
    }

    function setallnot(){

        var rowData = $("#grid-table").jqGrid('getGridParam','selarrrow');

        if(rowData.length)
        {
            var tmp = true;
            for(var i=0;i<rowData.length;i++)
            {
                var status= $("#grid-table").jqGrid('getCell',rowData[i],'status');
                if(status == '审核不过' || status == '兑换成功'){
                    alert("请选择新申请的兑换记录！");
                    tmp = false;
                    break;
                }
            }
        }else{
            alert("请选择兑换记录！");
            return false;
        }
        if(tmp){
            $( "#dialog-checknot .alert" ).find('span').html("确认批量审核不通过？");
            $( "#dialog-checknot" ).removeClass('hide').dialog({
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
                                url: "<?php echo Yii::app()->createUrl('/gift/checkallnot') ?>",
                                dataType : 'json',
                                data : {id:rowData} ,
                                success: function(msg){
                                    if(msg.type == 'success')
                                    {
                                        window.location.reload();
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
    }
</script>