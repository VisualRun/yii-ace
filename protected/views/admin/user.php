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
            'colNames' => ['员工编码', '账号', '类别', '姓名', '部门', '岗位', '状态', '备注'],
            'colModel' => [
                ['name' => 'code', 'index' => 'code', 'editable' => false],
                ['name' => 'account', 'index' => 'account', 'editable' => true],
                ['name' => 'typeId', 'index' => 'typeId', 'editable' => true, 'edittype' => 'select','editoptions' => ['value' => Yii::app()->params['user_type']]],
                ['name' => 'realname', 'index' => 'realname', 'editable' => true],
                ['name' => 'deptId', 'index' => 'deptId', 'editable' => true, 'edittype' => 'select','editoptions' => ['value' => CHtml::listData(Deptment::model()->findAllByAttributes(array('status'=>1)), 'id', 'name')]],
                ['name' => 'workplaceId', 'index' => 'workplaceId', 'editable' => true, 'edittype' => 'select','editoptions' => ['value' => CHtml::listData(Workplace::model()->findAllByAttributes(array('status'=>1)), 'id', 'name')]],
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
            'search' => ['multipleSearch' => true]
        ],
        'enableFilterToolbar' => true
      ]
    );
?>