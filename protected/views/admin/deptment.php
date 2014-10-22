<?php
    $this->widget('JqGridlist',
      [
        'viewData' => [
            'start'=>isset($_GET['start'])?$_GET['start']:"",
            'end'=>isset($_GET['end'])?$_GET['end']:""
        ],
        'model' => 'deptment',
        'gridSettings' => [
            'caption' => '部门管理',
            'colNames' => ['部门编码', '部门名称', '状态', '备注'],
            'colModel' => [
                ['name' => 'code', 'index' => 'code', 'editable' => true],
                ['name' => 'name', 'index' => 'name', 'editable' => true],
                ['name' => 'status', 'index' => 'status', 'editable' => true, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['status']]],
                ['name' => 'remark', 'index' => 'remark', 'editable' => true]
            ],
            'rowNum' => 1,
            'rowList' => [10,20,30],
            'autowidth' => true,
        ],
        'pagerSettings' => [
            'edit' => true,
            'add' => true,
            'del' => true,
            'search' => ['multipleSearch' => true]
        ],
        'enableFilterToolbar' => true
      ]
    );
?>