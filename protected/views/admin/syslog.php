<div class="col-xs-12">
<?php
    $this->widget('JqGridlist',
      [
        'viewData' => [
            'start'=>isset($_GET['start'])?$_GET['start']:"",
            'end'=>isset($_GET['end'])?$_GET['end']:""
        ],
        'model' => 'syslog',
        'gridSettings' => [
            'caption' => '最新动态',
            'colNames' => ['ID','动态类别', '内容', '时间'],
            'colModel' => [
                // ['name' => 'myac','index' => '', 'width' => 80, 'fixed' => 'true', 'sortable' => 'false', 'resize' => false, 'formatter' =>'actions', 'formatoptions' => ['key'=>true, 'delOptions'=>['recreateForm'=>true,'beforeShowForm'=>'beforeDeleteCallback']]],
                ['name' => 'id', 'index' => 'id', 'width' => 30, 'editable' => false],
                ['name' => 'typeId', 'index' => 'typeId', 'editable' => false],
                ['name' => 'content', 'index' => 'content', 'editable' => false],
                ['name' => 'createdTime', 'index' => 'createdTime', 'editable' => false, 'formatter'=> "date", 'formatoptions' => ['srcformat'=>'Y-m-d H:i:s','newformat'=>'y/m/d H:i']]
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
</div>