<?php
    $this->widget('JqGridlist',
      [
        'viewData' => [
            'start'=>isset($_GET['start'])?$_GET['start']:"",
            'end'=>isset($_GET['end'])?$_GET['end']:""
        ],
        'model' => 'purview',
        'gridSettings' => [
            'caption' => '权限管理',
            'colNames' => ['权限编码', '权限名称', '控制器名', '方法名', '状态','添加日期'],
            'colModel' => [
                ['name' => 'code', 'index' => 'code', 'editable' => false],
                ['name' => 'name', 'index' => 'name', 'editable' => true],
                ['name' => 'controller', 'index' => 'controller', 'editable' => true],
                ['name' => 'action', 'index' => 'action', 'editable' => true],
                ['name' => 'valid', 'index' => 'valid', 'editable' => true, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['valid']]],
                ['name' => 'createdTime', 'index' => 'createdTime', 'editable' => false, 'formatter'=> "date", 'formatoptions' => ['srcformat'=>'Y-m-d H:i:s','newformat'=>'H:i y/m/d']],

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