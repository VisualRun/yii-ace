<div class="col-xs-12">
	<!-- PAGE CONTENT BEGINS -->
	<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'task-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array(
            'class'=>'form-horizontal',
        ),
    )); ?>
	<?php echo $form->errorSummary(array($model)); ?>
    <?php $arr = $model->createField();?>
	<!-- #section:elements.form -->
		<?php if(!empty($arr)):?>
		<?php foreach ($arr as $key => $value):?>
		
			<?php if(!is_array($value)):?>
			<div class="form-group">
				<?php echo $form->labelEx($model,$key,array('class'=>'col-sm-3 control-label no-padding-right')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,$key,array('class'=>'col-xs-10 col-sm-5')); ?>
				</div>
				<?php echo $form->error($model,$key); ?>
			</div>
			<?php elseif($value['type']=='checkbox'):?>
			<div class="form-group">
				<?php echo $form->labelEx($model,$key,array('class'=>'col-sm-3 control-label no-padding-right')); ?>
				<div class="col-sm-9">
					<?php echo $form->dropDownList($model,$key,$value['data']); ?>
				</div>
				<?php echo $form->error($model,$key); ?>
			</div>
			<?php elseif($value['type']=='textarea'):?>
			<div class="form-group">
				<?php echo $form->labelEx($model,$key,array('class'=>'col-sm-3 control-label no-padding-right')); ?>
				<div class="col-sm-7">
					<?php echo $form->textArea($model,$key,array('class'=>'form-control limited autosize','maxlength'=>'140')); ?>
				</div>
				<?php echo $form->error($model,$key); ?>
			</div>
			<?php elseif($value['type']=='date'):?>
			<div class="form-group">
				<?php echo $form->labelEx($model,$key,array('class'=>'col-sm-3 control-label no-padding-right')); ?>
				<div class="col-sm-5">
					<?php echo $form->textField($model,$key,array('class'=>'date-picker','data-date-format'=>'yyyy-mm-dd')); ?>
				</div>
				<?php echo $form->error($model,$key); ?>
			</div>
			<?php elseif($value['type']=='file'):?>
			<div class="form-group">
				<?php echo $form->labelEx($model,$key,array('class'=>'col-sm-3 control-label no-padding-right')); ?>
				<div class="col-sm-5">
					<?php echo $form->fileField($model,$key,array('class'=>'id-input-file')); ?>
				</div>
				<?php echo $form->error($model,$key); ?>
			</div>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php endif; ?>
		
		<div class="space-4"></div>

		<div class="clearfix form-actions">
			<div class="col-md-offset-3 col-md-9">
				<button class="btn btn-info" type="submit">
					<i class="ace-icon fa fa-check bigger-110"></i>
					提 交
				</button>

				&nbsp; &nbsp; &nbsp;
				<button class="btn" type="reset">
					<i class="ace-icon fa fa-undo bigger-110"></i>
					重 置
				</button>
			</div>
		</div>
	<?php $this->endWidget(); ?>
</div>