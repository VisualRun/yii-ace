<div class="col-xs-12">
	<!-- PAGE CONTENT BEGINS -->
	<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'new-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array(
        	'name'=>'task_form',
	    'enctype'=>'multipart/form-data',
            'class'=>'form-horizontal',
            'onSubmit'=>'return GetCheckbox()',
        ),
    )); ?>
	<?php echo $form->errorSummary(array($model)); ?>
    <?php $arr = $model->createField();?>
	<!-- #section:elements.form -->
		<?php if(!empty($arr)):?>
		<?php foreach ($arr as $key => $value):?>

			<?php if(!is_array($value)):?>
			<div class="form-group">
				<?php echo $form->labelEx($model,$key,array('class'=>'col-sm-2 control-label no-padding-right')); ?>
				<div class="col-sm-10">
					<?php echo $form->textField($model,$key,array('class'=>'col-xs-10 col-sm-5')); ?>
				</div>
				<?php echo $form->error($model,$key); ?>
			</div>
			<?php elseif($value['type']=='text'):?>
			<div class="form-group">
				<?php echo $form->labelEx($model,$key,array('class'=>'col-sm-2 control-label no-padding-right')); ?>
				<div class="col-sm-5">
					<?php echo $form->textField($model,$key,array('class'=>'col-xs-10 col-sm-5')); ?>
				</div>
				<?php echo $form->error($model,$key); ?>
			</div>
			<?php elseif($value['type']=='checkbox'):?>
			<?php if($key == 'assignedId'): ?>
			<div id="group_assignedId" class="form-group <?php if($model->scenario == 'new' || $model->typeId == 2): ?>hide<?php endif;?>">
				<?php echo $form->labelEx($model,$key,array('class'=>'col-sm-2 control-label no-padding-right')); ?>
				<div class="col-sm-10">

					<select id="Task_<?php echo $key;?>" name="Task[<?php echo $key;?>]" value='<?php echo $model->{$key};?>' >
		                <option value=""> 请选择 </option>
		                <?php foreach ($value['data'] as $k =>$v):?>
		                <option <?php if(isset($model->{$key}) && is_numeric($model->{$key}) && $model->{$key} == $k): ?>selected="selected"<?php endif; ?> value="<?php echo $k;?>">
		                    <?php echo $v;?>
		                </option>
		                <?php endforeach;?>
		            </select>

				</div>
				<?php echo $form->error($model,$key); ?>
			</div>
			<?php else: ?>
			<div class="form-group">
				<?php echo $form->labelEx($model,$key,array('class'=>'col-sm-2 control-label no-padding-right')); ?>
				<div class="col-sm-10">

					<select id="Task_<?php echo $key;?>" name="Task[<?php echo $key;?>]" value='<?php echo $model->{$key};?>' >
		                <option value=""> 请选择 </option>
		                <?php foreach ($value['data'] as $k =>$v):?>
		                <option <?php if(isset($model->{$key}) && is_numeric($model->{$key}) && $model->{$key} == $k): ?>selected="selected"<?php endif; ?> value="<?php echo $k;?>">
		                    <?php echo $v;?>
		                </option>
		                <?php endforeach;?>
		            </select>

				</div>
				<?php echo $form->error($model,$key); ?>
			</div>
			<?php endif; ?>
			<?php elseif($value['type']=='textarea'):?>
			<div class="form-group">
				<?php echo $form->labelEx($model,$key,array('class'=>'col-sm-2 control-label no-padding-right')); ?>
				<div class="col-sm-7">
					<?php echo $form->textArea($model,$key,array('class'=>'form-control limited autosize','maxlength'=>'140')); ?>
				</div>
				<?php echo $form->error($model,$key); ?>
			</div>
			<?php elseif($value['type']=='editor'):?>
			<div class="form-group">
				<?php echo $form->labelEx($model,$key,array('class'=>'col-sm-2 control-label no-padding-right')); ?>
				<div class="col-sm-10">
					<div class="wysiwyg-editor" id="<?php echo Yii::app()->controller->modelClass ?>_<?php echo $key ?>"><?php echo $model->$key ?></div>
				</div>
				<?php echo $form->error($model,$key); ?>
			</div>
			<?php elseif($value['type']=='date'):?>
			<?php if($key == 'deadline'): ?>
			<div class="form-group <?php if($model->scenario == 'new'): ?><?php else: ?><?php if($model->deadline_type == 2): ?>hide<?php endif; ?><?php endif; ?>" id="deadline1">
				<?php echo $form->labelEx($model,$key,array('class'=>'col-sm-2 control-label no-padding-right')); ?>
				<div class="col-sm-5">
					<?php echo CHtml::textField('deadline_1',$model->{$key},array('class'=>'date-picker','data-date-format'=>'yyyy-mm-dd')) ?>
				</div>
				<?php echo $form->error($model,$key); ?>
			</div>
			<div class="form-group <?php if($model->scenario == 'new'): ?>hide<?php else: ?><?php if($model->deadline_type == 1): ?>hide<?php endif; ?><?php endif; ?>" id="deadline2">
				<?php echo $form->labelEx($model,$key,array('class'=>'col-sm-2 control-label no-padding-right')); ?>
				<div class="col-sm-5">
					<?php echo CHtml::textField('deadline_2',$model->{$key},array('class'=>'col-xs-2 col-sm-2')) ?>
				</div>
				<?php echo $form->error($model,$key); ?>
			</div>
			<?php else: ?>
			<div class="form-group">
				<?php echo $form->labelEx($model,$key,array('class'=>'col-sm-2 control-label no-padding-right')); ?>
				<div class="col-sm-5">
					<?php echo $form->textField($model,$key,array('class'=>'date-picker','data-date-format'=>'yyyy-mm-dd')); ?>
				</div>
				<?php echo $form->error($model,$key); ?>
			</div>
			<?php endif; ?>
			<?php elseif($value['type'] == 'file' && $key == 'attach'):?>
			<div class="form-group">
				<label class="col-sm-2 control-label no-padding-right" for="attach">附件</label>
				<div class="col-sm-5">
					<input name="attach" id="attach" type="file" multiple="" />
				</div>
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
<div id="dialog-notice" class="hide">
    <div class="alert alert-info">
        <span></span>
    </div>
</div>
<script type="text/javascript">
	jQuery(function($) {
		$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
	        _title: function(title) {
	            var $title = this.options.title || '&nbsp;'
	            if( ("title_html" in this.options) && this.options.title_html == true )
	                title.html($title);
	            else title.text($title);
	        }
	    }));
	})

	function dialog_notice(str){
		$( "#dialog-notice .alert span" ).html(str);
		$( "#dialog-notice" ).removeClass('hide').dialog({
			resizable: false,
            modal: true,
            title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> 提醒</h4></div>",
            title_html: true,
            buttons: [
                    {
                        html: "<i class='ace-icon fa fa-check bigger-110'></i>&nbsp; 确认",
                        "class" : "btn btn-danger btn-xs",
                        click: function() {
                        	$( this ).dialog( "close" );
                        }
                    }
                ]
		})
	}

	var GetCheckbox = function (){
		var typeId = $('#Task_typeId option:selected').val();
		if(typeId == '')
		{
			dialog_notice('请选择主次类别！');
			return false;
		}
		var imtypeId = $('#Task_imtypeId option:selected').val();
		if(imtypeId == '')
		{
			dialog_notice('请选择重要类别！');
			return false;
		}
		var name = $('#Task_name').val();
		if(name == '')
		{
			dialog_notice('请填写任务名称！');
			return false;
		}
		var desc = $('#Task_desc').val();
		if(desc == '')
		{
			dialog_notice('请填写任务说明！');
			return false;
		}
		var point = $('#Task_point').val();
		if(point == '')
		{
			dialog_notice('请填写奖励积分！');
			return false;
		}
		if(isNaN(point))
		{
			dialog_notice('请填写正确的奖励积分！');
			return false;
		}

		var deadline_type = $('#Task_deadline_type option:selected').val();
		if(deadline_type == '')
		{
			dialog_notice('请选择最后时限类别！');
			return false;
		}

		var deadline = $('#deadline_'.deadline_type).val();
		if(deadline == '')
		{
			dialog_notice('任务最后时限不能为空！');
			return false;
		}

		if(deadline_type == 2)
		{
			if(isNaN(deadline))
			{
				dialog_notice('小时数必须是数字！');
				return false;
			}
		}

		if(typeId == 1)
		{
			var assignedId = $('#Task_assignedId option:selected').val();
			if(assignedId == '')
			{
				dialog_notice('请选择任务接受人！');
				return false;
			}
		}
    }

	$(function(){
		$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
	        _title: function(title) {
	            var $title = this.options.title || '&nbsp;'
	            if( ("title_html" in this.options) && this.options.title_html == true )
	                title.html($title);
	            else title.text($title);
	        }
	    }));

		$("#Task_typeId").on('change', function(e) {
			var tmptype = $(this).find('option:selected').val();
			if(tmptype == 1)
			{
			 	$('#group_assignedId').removeClass('hide');
			}else{
			 	$('#group_assignedId').addClass('hide');
			}
		})

		$("#Task_deadline_type").on('change', function(e) {
			var tmptype = $(this).find('option:selected').val();
			if(tmptype == 1)
			{
			 	$('#deadline1').removeClass('hide');
			 	$('#deadline2').addClass('hide');
			}else if(tmptype == 2){
				$('#deadline1').addClass('hide');
			 	$('#deadline2').removeClass('hide');
			}else{
			 	$('#deadline1').addClass('hide');
			 	$('#deadline2').addClass('hide');
			}
		})

		$('textarea[class*=autosize]').autosize({append: "\n"});
		$('textarea.limited').inputlimiter({
			remText: '%n 字符剩余...',
			limitText: '最多允许 : %n.'
		});
	})
</script>
