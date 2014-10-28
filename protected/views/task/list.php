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
            'colNames' => ['任务编码', '主次类别', '重要类别', '任务名称', '创建人', '创建时间', '状态','最后操作人ID', '最后操作时间'],
            'colModel' => [
                ['name' => 'code', 'index' => 'code', 'editable' => false],
                ['name' => 'typeId', 'index' => 'typeId', 'editable' => false, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['task_type']]],
                ['name' => 'imtypeId', 'index' => 'imtypeId', 'editable' => false, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['task_important_type']]],
                ['name' => 'name', 'index' => 'name', 'editable' => false],
                ['name' => 'openedId', 'index' => 'openedId', 'editable' => false],
                ['name' => 'openedDate', 'index' => 'openedDate', 'editable' => false],
                ['name' => 'status', 'index' => 'status', 'editable' => false, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['task_status']]],
                ['name' => 'lastEditedId', 'index' => 'lastEditedId', 'editable' => false],
                ['name' => 'lastEditedDate', 'index' => 'lastEditedDate', 'editable' => false]

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
        'enableFilterToolbar' => true
      ]
    );
?>