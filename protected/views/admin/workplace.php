<div class="col-xs-12">
<div class="row">
    <?php $this->renderPartial('/actions/_search',array('model'=>$model,)); ?>
</div>
<div class="space-10"></div>
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
</div>