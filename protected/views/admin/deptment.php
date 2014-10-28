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
                // ['name' => 'myac','index' => '', 'width' => 80, 'fixed' => 'true', 'sortable' => 'false', 'resize' => false, 'formatter' =>'actions', 'formatoptions' => ['key'=>true, 'delOptions'=>['recreateForm'=>true,'beforeShowForm'=>'beforeDeleteCallback']]],
                ['name' => 'code', 'index' => 'code', 'editable' => false],
                ['name' => 'name', 'index' => 'name', 'editable' => true],
                ['name' => 'status', 'index' => 'status', 'editable' => true, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['status']]],
                ['name' => 'remark', 'index' => 'remark', 'editable' => true, 'edittype' => 'textarea']
            ],
            'rowNum' => 10,
            'rowList' => [10,20,30],
            'autowidth' => true,
        ],
        'pagerSettings' => [
            'edit' => true,
            'add' => true,
            'del' => true,
            //'search' => ['multipleSearch' => true]
            'search' => false,
        ],
        'enableFilterToolbar' => true
      ]
    );
?>