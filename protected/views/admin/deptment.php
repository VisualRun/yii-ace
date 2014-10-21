<?php
    $this->widget('JqGridlist',
      [
        'caption' => '部门管理',
        'model' => $model,
        'viewData' => [
            'start'=>isset($_GET['start'])?$_GET['start']:"",
            'end'=>isset($_GET['end'])?$_GET['end']:""
        ],
        'requestUrl' => Yii::app()->request->getUrl(),
        'gridSettings' => [
            'colNames' => ['Title', 'Author', 'Language'],
            'colModel' => [
                ['name' => 'title', 'index' => 'title', 'editable' => true],
                ['name' => 'author', 'index' => 'author', 'editable' => true],
                ['name' => 'language', 'index' => 'language', 'editable' => true]
            ],
            'rowNum' => 10,
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