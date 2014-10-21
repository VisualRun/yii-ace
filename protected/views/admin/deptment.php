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
                // ['name' => 'myac', 'index' => '', 'width' => '80', 'fixed' => 'true', 'sortable' => false ],
                ['name' => 'code', 'index' => 'title', 'editable' => true],
                ['name' => 'name', 'index' => 'author', 'editable' => true],
                ['name' => 'statusid', 'index' => 'language', 'editable' => true],
                ['name' => 'remark', 'index' => 'language', 'editable' => true]
            ],
            'rowNum' => 2,
            'rowList' => [2,4,6],
            'autowidth' => true,
            'height' => 'auto',
            
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