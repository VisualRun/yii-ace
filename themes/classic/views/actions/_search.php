<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
}); 
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('form-grid', {
        data: $(this).serialize()
    });
    return false;
});
");

?>
<?php $arr = $model->searchField();?>


<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?><?php if(!empty($arr)):?>
<?php foreach ($arr as $key => $value):?>
    <span class="row">
        <?php echo $form->label($model,$key); ?>
        <?php echo $form->textField($model,$key); ?>
    </span>
<?php endforeach;?><?php endif;?>
 <div class="row" style="width:auto;float:left"><span>
      时间 ：</span><?php 
$this->widget('zii.widgets.jui.CJuiDatePicker',array(
    'attribute'=>'start_time',
    'language'=>'zh_cn',
    'name'=>'start_time',
    'options'=>array(
        'dateFormat'=>'yy-mm-dd ',
    ),
    'htmlOptions'=>array(
        'style'=>'height:18px;margin:0;',
    ),
));
?>
     <span style="padding-left:10px"> 至：</span>
     <?php 
$this->widget('zii.widgets.jui.CJuiDatePicker',array(
    'attribute'=>'end_time',
    'language'=>'zh_cn',
    'name'=>'end_time',
    'options'=>array(
        'dateFormat'=>'yy-mm-dd ',
    ),
    'htmlOptions'=>array(
        'style'=>'height:18px;margin:0;',
    ),
));
?> 
    </div> <span> <div class="ic_button" style="padding-left:0px;float:left">
        <?php echo CHtml::submitButton(Yii::t('user','Search'),array('class'=>'button_b_Db','style'=>'width:86px;margin-top:0')); ?>
    </div></span>
    

    

<?php $this->endWidget(); ?>
<div class="ic_button" style="padding-left:0px;float:left">
<input type="button" value="刷新页面" onClick="window.location.reload();"/>
</div></span>
</div>

