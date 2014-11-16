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
        'model' => 'gift',
        'gridSettings' => [
            'caption' => '兑换物品管理',
            'colNames' => ['物品编码','物品名称','需要积分','可兑换数量','状态','添加人','添加时间'],
            'colModel' => [
                ['name' => 'code', 'index' => 'code', 'editable' => false],
                ['name' => 'name', 'index' => 'name', 'editable' => true],
                ['name' => 'score', 'index' => 'score', 'editable' => true],
                ['name' => 'num', 'index' => 'num', 'editable' => true],
                ['name' => 'status', 'index' => 'status', 'editable' => true, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['status']]],
                ['name' => 'addId', 'index' => 'addId', 'editable' => false],
                ['name' => 'addDate', 'index' => 'addDate', 'editable' => false, 'formatter'=> "date", 'formatoptions' => ['srcformat'=>'Y-m-d H:i:s','newformat'=>'y/m/d H:i']]
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