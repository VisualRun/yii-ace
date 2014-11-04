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
        'model' => 'userpurview',
        'gridSettings' => [
            'caption' => '用户类别权限',
            'colNames' => ['用户类别', '权限编码', '权限名称', '状态','添加日期'],
            'colModel' => [
                ['name' => 'usertypeId', 'index' => 'usertypeId', 'editable' => true, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['user_type']]],
                ['name' => 'purviewId', 'index' => 'purviewId', 'editable' => true, 'edittype' => 'select','editoptions' => ['value' => CHtml::listData(Purview::model()->findAllByAttributes(array('valid'=>1)), 'id', 'name')]],
                ['name' => 'purviewName', 'index' => 'purviewId', 'editable' => false],
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
</div>