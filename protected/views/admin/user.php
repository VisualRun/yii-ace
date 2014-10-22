<?php
    $this->widget('JqGridlist',
      [
        'viewData' => [
            'start'=>isset($_GET['start'])?$_GET['start']:"",
            'end'=>isset($_GET['end'])?$_GET['end']:""
        ],
        'model' => 'user',
        'gridSettings' => [
            'caption' => '员工管理',
            'colNames' => ['员工编码', '账号', '类别', '姓名', '状态', '备注'],
            'colModel' => [
                ['name' => 'code', 'index' => 'code', 'editable' => true],
                ['name' => 'account', 'index' => 'account', 'editable' => true],
                ['name' => 'type', 'index' => 'type', 'editable' => true],
                ['name' => 'realname', 'index' => 'realname', 'editable' => true],
                ['name' => 'statusid', 'index' => 'statusid', 'editable' => true],
                ['name' => 'remark', 'index' => 'remark', 'editable' => true]
            ],
            'rowNum' => 10,
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