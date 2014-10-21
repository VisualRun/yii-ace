<script type="text/javascript">
/*<![CDATA[*/
	function news_form(form){
		<?php echo $_REQUEST['target']=='navTab'? 'navTab': '$.pdialog';?>.reload(form.action, $(form).serializeArray());
		return false;
	}
/*]]>*/
</script>
<style>.alert .alertInner .msg{max-height:600px;overflow:visible;}</style>
<div class="form pageFormContent" layoutH="55">
	<?php $form=$this->beginWidget('CActiveForm', array(
    	'id'=>'news-form',
        'htmlOptions'=>array(
            'class'=>"pageForm required-validate",
            'enctype'=>'multipart/form-data',
          	'onsubmit'=>"return iframeCallback(this, dialogAjaxDone);",
        ),
	)); ?>
<?php echo $form->errorSummary(array($model)); ?>
<?php $arr = $model->createField();?>
<?php if(!empty($arr)):?>
	<?php foreach ($arr as $key => $value):?>
	<?php if(!is_array($value)):?>
	<div class="unit">
		<?php echo $form->labelEx($model,$key); ?>
		<?php echo $form->textField($model,$key,array('size'=>20)); ?>
		<?php echo $form->error($model,$key); ?>
	</div>
	<?php elseif($value['type']=='file'):?>
	<div class="unit">
			<?php echo $form->labelEx($model,$key); ?>
			<?php if($model->isNewRecord):?>
			<?php echo CHtml::activeFileField($model,$key,array('class'=>'required')); ?>（尺寸：137x137）
			<?php else:?>
			<?php echo CHtml::activeFileField($model,$key); ?>（尺寸：137x137）
			<?php endif;?>
			<?php echo $form->error($model,$key); ?>
	</div>
	<?php elseif($value['type']=='checkbox'):?>
	<div class="unit">
		<?php echo $form->labelEx($model,$key); ?>
		<?php echo $form->dropDownList($model,$key,$value['data']); ?>
		<?php echo $form->error($model,$key); ?>
	</div>
	<?php elseif($value['type']=='textarea'):?>
	<div class="unit">
		<?php echo $form->labelEx($model,$key); ?>
		<?php echo $form->textArea($model,$key,array( "cols"=>"40","rows"=>"3")); ?>
		<?php echo $form->error($model,$key); ?>
	</div>
	<?php endif;?>
	<?php endforeach;?>
	<?php endif;?>
	<div style="clear:both;"></div>
	<div class="formBar" style="margin-top:10px;">
		<ul>
			<li><div class="buttonActive"><div class="buttonContent">
				<button type="submit"><?php echo $model->isNewRecord ? '保存' : '修改'; ?>
				</button>
			</div></div>
			</li>
			<li>
				<div class="button"><div class="buttonContent">
					<button onclick="<?php echo $_REQUEST['target']=='navTab'? 'navTab.closeCurrentTab()': '$.pdialog.closeCurrent()';?>" type="Button">取消</button>
				</div></div>
			</li>
		</ul>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->