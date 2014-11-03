<div class="col-xs-12">
<div class="row">
    <div class="col-sm-6">
        <div class="alert alert-success">
            <strong>我的总积分：</strong>
            <?php echo $user->point ?>
            <br>
        </div>
    </div>
</div>
<div class="row">
    <?php $this->renderPartial('_point',array('model'=>$model,)); ?>
</div>
<div class="space-10"></div>
<?php
    $this->widget('JqGridlist',
      [
        'model' => 'pointlog',
        'gridSettings' => [
            'caption' => '我的积分',
            'colNames' => ['积分ID', '积分类别', '积分值', '积分说明', '创建时间'],
            'colModel' => [
                ['name' => 'id', 'index' => 'id', 'width' => '40', 'editable' => false],
                ['name' => 'log_type', 'index' => 'log_type', 'width' => '60', 'editable' => false],
                ['name' => 'log_point', 'index' => 'log_point', 'width' => '60', 'editable' => false,],
                ['name' => 'log_desc', 'index' => 'log_desc', 'editable' => false],
                ['name' => 'createdTime', 'index' => 'createdTime', 'width' => '60', 'editable' => false, 'formatter'=> "date", 'formatoptions' => ['srcformat'=>'Y-m-d H:i:s','newformat'=>'H:i y/m/d']],
            ],
            'rowNum' => 10,
            'rowList' => [10,20,30],
            'autowidth' => true,

        ],
        'pagerSettings' => [
            'edit' => false,
            'add' => false,
            'del' => false,
            'search' => false,
            'view' => false,
        ],
        'enableFilterToolbar' => true,
        'resultType'=>'myresult',
      ]
    );
?>
</div>