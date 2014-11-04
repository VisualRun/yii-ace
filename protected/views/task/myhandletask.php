<div class="col-xs-12">
<div class="row">
    <?php $this->renderPartial('_searchmyhandle',array('model'=>$model,)); ?>
</div>
<div class="space-10"></div>
<?php
    $this->widget('JqGridlist',
      [
        'viewData' => [
            'start'=>isset($_GET['start'])?$_GET['start']:"",
            'end'=>isset($_GET['end'])?$_GET['end']:""
        ],
        'model' => 'task',
        'gridSettings' => [
            'caption' => '任务列表',
            'colNames' => ['任务编码', '任务名称', '主次类别', '重要类别', '创建人', '接收人', '状态','最后操作人ID', '最后操作时间', '操作'],
            'colModel' => [
                ['name' => 'code', 'index' => 'code', 'width' => '130', 'editable' => false],
                ['name' => 'name', 'index' => 'name', 'editable' => false],
                ['name' => 'typeId', 'index' => 'typeId', 'width' => '80', 'editable' => false, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['task_type']]],
                ['name' => 'imtypeId', 'index' => 'imtypeId', 'width' => '80', 'editable' => false, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['task_important_type']]],
                ['name' => 'openedId', 'index' => 'openedId', 'editable' => false],
                ['name' => 'assignedId', 'index' => 'assignedId', 'editable' => false],
                ['name' => 'status', 'index' => 'status', 'width' => '60', 'editable' => false, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['task_status']]],
                ['name' => 'lastEditedId', 'index' => 'lastEditedId', 'editable' => false],
                ['name' => 'lastEditedDate', 'index' => 'lastEditedDate', 'editable' => false, 'formatter'=> "date", 'formatoptions' => ['srcformat'=>'Y-m-d H:i:s','newformat'=>'H:i y/m/d']],
                ['name' => 'hand', 'index' => 'hand', 'editable' => false]
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
        'resultType'=>'myhandleresult',
      ]
    );
?>
</div>