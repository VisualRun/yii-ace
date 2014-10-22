<?php
    $this->widget('JqGridlist',
      [
        'viewData' => [
            'start'=>isset($_GET['start'])?$_GET['start']:"",
            'end'=>isset($_GET['end'])?$_GET['end']:""
        ],
        'model' => 'workplace',
        'gridSettings' => [
            'caption' => '岗位管理',
            'colNames' => ['岗位编码', '岗位名称', '状态', '备注'],
            'colModel' => [
                ['name' => 'code', 'index' => 'code', 'editable' => true],
                ['name' => 'name', 'index' => 'name', 'editable' => true],
                ['name' => 'status', 'index' => 'status', 'editable' => true, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['status']]],
                ['name' => 'remark', 'index' => 'remark', 'editable' => true]
            ],
            'rowNum' => 10,
            'rowList' => [10,20,30],
            'autowidth' => true,

        ],
        'pagerSettings' => [
            'edit' => true,
            //'editicon' => 'ace-icon fa fa-pencil blue',
            'add' => true,
            //'addicon' => 'ace-icon fa fa-plus-circle purple',
            'del' => true,
            //'delicon' => 'ace-icon fa fa-trash-o red',
            'search' => ['multipleSearch' => true]
        ],
        'enableFilterToolbar' => true
      ]
    );
?>