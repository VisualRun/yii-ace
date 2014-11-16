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
        'model' => 'giftexchange',
        'gridSettings' => [
            'caption' => '个人兑换记录',
            'colNames' => ['记录编码','物品名称','兑换积分','状态'],
            'colModel' => [
                ['name' => 'code', 'index' => 'code', 'editable' => false],
                ['name' => 'giftId', 'index' => 'giftId', 'editable' => true],
                ['name' => 'score', 'index' => 'score', 'editable' => true],
                ['name' => 'status', 'index' => 'status', 'editable' => true],
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