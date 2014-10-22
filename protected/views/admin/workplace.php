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
                // ['name' => 'myac', 'index' => '', 'width' => '80', 'fixed' => 'true', 'sortable' => false ],
                ['name' => 'code', 'index' => 'title', 'editable' => true],
                ['name' => 'name', 'index' => 'author', 'editable' => true],
                ['name' => 'statusid', 'index' => 'language', 'editable' => true],
                ['name' => 'remark', 'index' => 'language', 'editable' => true]
            ],
            'rowNum' => 10,
            'rowList' => [10,20,30],
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