<div class="col-xs-12" >

	<!-- PAGE CONTENT BEGINS -->
	<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'new-form',
	'enableClientValidation' => false,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
	'htmlOptions' => array(
		'name' => 'task_form',
		'enctype' => 'multipart/form-data',
		'class' => 'form-horizontal',
		'onSubmit' => 'return GetCheckbox()',
	),
));?>
	<div id ="task_list">
	<div class="form_task" id="form_task" data-myid="0">
		<h3 class="header smaller lighter purple">
		<i class="form_task_close ace-icon glyphicon glyphicon-remove hide" onclick="close_form(this)" ></i>
		任务信息</h3>
		<?php echo $form->errorSummary(array($model));?>
	    <?php $arr = $model->createField();?>
		<!-- #section:elements.form -->
			<?php if (!empty($arr)): ?>
			<?php foreach ($arr as $key => $value): ?>

				<?php if (!is_array($value)): ?>
				<div class="form-group">
					<?php echo $form->labelEx($model, $key, array('class' => 'col-sm-2 control-label no-padding-right'));?>
					<div class="col-sm-10">
						<input type="text" name="Task[<?php echo $key;?>][]" class="col-xs-10 col-sm-5 Task_<?php echo $key;?>" value="<?php echo $model->{$key};?>">
					</div>
					<?php echo $form->error($model, $key);?>
				</div>
				<?php elseif ($value['type'] == 'text'): ?>
				<div class="form-group">
					<?php echo $form->labelEx($model, $key, array('class' => 'col-sm-2 control-label no-padding-right'));?>
					<div class="col-sm-5">
						<input type="text" name="Task[<?php echo $key;?>][]" class="col-xs-10 col-sm-5 Task_<?php echo $key;?>" value="<?php echo $model->{$key};?>">
					</div>
					<?php echo $form->error($model, $key);?>
				</div>
				<?php elseif ($value['type'] == 'checkbox'): ?>
				<?php if ($key == 'assignedId'): ?>
				<div class="group_assignedId form-group <?php if ($model->scenario == 'new' || $model->typeId == 2): ?>hide<?php endif;?>">
					<?php echo $form->labelEx($model, $key, array('class' => 'col-sm-2 control-label no-padding-right'));?>
					<div class="col-sm-10">
						<?php if ($model->scenario == 'new'): ?>
						<p style="height:5px;margin:0px;">&nbsp;</p>
						<?php foreach ($value['data'] as $k => $v): ?>
			            <label>
			                <input type="checkbox" value="<?php echo $k;?>" class="ace assignedIdGroup" name="Task[assignedIdtmp0][]">
			                <span class="lbl"> <?php echo $v;?> &nbsp;&nbsp;&nbsp;&nbsp;</span>
			            </label>
			            <?php endforeach;?>
						<?php else: ?>
						<select class="Task_<?php echo $key;?>" name="Task[assignedIdtmp0][]" value='<?php echo $model->{$key};?>' >
			                <option value=""> 请选择 </option>
			                <?php foreach ($value['data'] as $k => $v): ?>
			                <option <?php if (isset($model->{$key}) && is_numeric($model->{$key}) && $model->{$key} == $k): ?>selected="selected"<?php endif;?> value="<?php echo $k;?>">
			                    <?php echo $v;?>
			                </option>
			                <?php endforeach;?>
			            </select>
						<?php endif;?>
					</div>
					<?php echo $form->error($model, $key);?>
				</div>
				<?php else: ?>
				<div class="form-group">
					<?php echo $form->labelEx($model, $key, array('class' => 'col-sm-2 control-label no-padding-right'));?>
					<div class="col-sm-10">
						<select <?php if ($key == 'typeId'): ?>onchange="changetypeId(this)"<?php elseif ($key == 'deadline_type'): ?>onchange="changedeadlineType(this)"<?php endif;?> class="Task_<?php echo $key;?>" name="Task[<?php echo $key;?>][]" value='<?php echo $model->{$key};?>' >
			                <option value=""> 请选择 </option>
			                <?php foreach ($value['data'] as $k => $v): ?>
			                <option <?php if (isset($model->{$key}) && is_numeric($model->{$key}) && $model->{$key} == $k): ?>selected="selected"<?php endif;?> value="<?php echo $k;?>">
			                    <?php echo $v;?>
			                </option>
			                <?php endforeach;?>
			            </select>

					</div>
					<?php echo $form->error($model, $key);?>
				</div>
				<?php endif;?>
				<?php elseif ($value['type'] == 'textarea'): ?>
				<div class="form-group">
					<?php echo $form->labelEx($model, $key, array('class' => 'col-sm-2 control-label no-padding-right'));?>
					<div class="col-sm-7">
						<textarea name="Task[<?php echo $key;?>][]" class="Task_<?php echo $key;?> form-control limited autosize" maxlength="140"><?php echo $model->{$key};?></textarea>
					</div>
					<?php echo $form->error($model, $key);?>
				</div>
				<?php elseif ($value['type'] == 'date'): ?>
				<?php if ($key == 'deadline'): ?>
				<div class="deadline1 form-group <?php if ($model->scenario == 'new'): ?><?php else: ?><?php if ($model->deadline_type == 2): ?>hide<?php endif;?><?php endif;?>" >
					<label for="Task_deadline" class="col-sm-2 control-label no-padding-right required">任务最后时限(按天) <span class="required">*</span></label>
					<div class="col-sm-5">
						<input type="text" name="deadline_1[]" class="Task_<?php echo $key;?>1 Task_<?php echo $key;?> date-picker" data-date-format="yyyy-mm-dd" value="<?php echo $model->{$key};?>">（日期格式必须正确）
					</div>
					<?php echo $form->error($model, $key);?>
				</div>
				<div class="deadline2 form-group <?php if ($model->scenario == 'new'): ?>hide<?php else: ?><?php if ($model->deadline_type == 1): ?>hide<?php endif;?><?php endif;?>" >
					<label for="Task_deadline" class="col-sm-2 control-label no-padding-right required">任务最后时限(按小时) <span class="required">*</span></label>
					<div class="col-sm-5">
						<input type="text" name="deadline_2[]" class="Task_<?php echo $key;?>2 Task_<?php echo $key;?>" value="<?php echo !empty($model->{$key}) ? $model->{$key} : '1';?>">
					</div>
					<?php echo $form->error($model, $key);?>
				</div>
				<?php else: ?>
				<div class="form-group">
					<?php echo $form->labelEx($model, $key, array('class' => 'col-sm-2 control-label no-padding-right'));?>
					<div class="col-sm-5">
						<?php //echo $form->textField($model, $key, array('class' => 'date-picker', 'data-date-format' => 'yyyy-mm-dd'));?>
						<input type="text" name="Task[<?php echo $key;?>][]" class="Task_<?php echo $key;?> date-picker" data-date-format="yyyy-mm-dd" value="<?php echo $model->{$key};?>">
					</div>
					<?php echo $form->error($model, $key);?>
				</div>
				<?php endif;?>
				<?php elseif ($value['type'] == 'file' && $key == 'attach'): ?>
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right" for="attach">附件</label>
					<div class="col-sm-5">
						<input name="attachtmp0" class="attach" id="attach" type="file" multiple="" />
					</div>
				</div>
				<?php endif;?>
			<?php endforeach;?>
			<?php endif;?>
			<input type="hidden" name="Task[tmpid][]" value="tmp0">
			<div class="space-4"></div>
		</div>
		</div>
		<div class="clearfix form-actions">
			<div class="col-md-offset-3 col-md-9">
				<?php if ($model->isNewRecord): ?>
				<a class="btn btn-info" onclick="add_again()">
					<i class="ace-icon fa fa-check bigger-110"></i>
					添加多个
				</a>
				&nbsp;&nbsp;&nbsp;
				<?php endif;?>
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
	<?php $this->endWidget();?>
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

		$('textarea[class*=autosize]').autosize({append: "\n"});
		$('textarea.limited').inputlimiter({
			remText: '%n 字符剩余...',
			limitText: '最多允许 : %n.'
		});

	})

	function changetypeId(obj){
		var tmptype = $(obj).find('option:selected').val();
		if(tmptype == 1)
		{
		 	$(obj).parents(".form_task").find('.group_assignedId').removeClass('hide');
		}else{
			$(obj).parents(".form_task").find('.group_assignedId').addClass('hide');
		}
	}

	function changedeadlineType(obj){
		var tmptype = $(obj).find('option:selected').val();
		if(tmptype == 1)
		{
		 	$(obj).parents(".form_task").find('.deadline1').removeClass('hide');
		 	$(obj).parents(".form_task").find('.deadline2').addClass('hide');
		}else if(tmptype == 2){
			$(obj).parents(".form_task").find('.deadline1').addClass('hide');
		 	$(obj).parents(".form_task").find('.deadline2').removeClass('hide');
		}else{
		 	$(obj).parents(".form_task").find('.deadline1').addClass('hide');
		 	$(obj).parents(".form_task").find('.deadline2').addClass('hide');
		}
	}

	function add_again(){
		var myid = parseInt($(".form_task:last").data("myid"));
		myid++;

		var tmpmystr = "tmp"+myid;

		var html = $("#form_task").html();
		var html = "<div data-myid='"+myid+"' class='form_task'>"+html+"</div>";
		var html = html.replace(/tmp0/g, tmpmystr)

		$("#task_list").append(html);
		$("div[data-myid='"+myid+"']").find('.form_task_close').removeClass('hide');

		$("div[data-myid='"+myid+"']").find('textarea').html("");

		$('textarea[class*=autosize]').autosize({append: "\n"});
		$('textarea.limited').inputlimiter({
			remText: '%n 字符剩余...',
			limitText: '最多允许 : %n.'
		});

		$("div[data-myid='"+myid+"']").find('.Task_deadline1').addClass("tdl"+myid);

		$(".tdl"+myid).datepicker({
			autoclose: true,
			todayHighlight: true,
			dateFormat: 'yy-mm-dd',
    	});
	}

	function close_form(obj){
		$(obj).parent().parent().remove();
	}


	function dialog_notice(str){
		$( "#dialog-notice .alert span" ).html(str);
		$( "#dialog-notice" ).removeClass('hide').dialog({
			resizable: false,
            modal: true,
            width: 500,
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
		var tmp = false;

		$(".Task_typeId").each(function(){
			var typeId = $(this).find('option:selected').val();
			if(typeId == ''){
				dialog_notice('请选择任务类别！');
				tmp = true;
				return false;
			}
			if(!tmp){
				if(typeId == 1)
				{
					<?php if ($model->scenario == 'new'): ?>
					var chk_value =[];
		            $('.assignedIdGroup:checked').each(function(){
		            	chk_value.push($(this).val());
		            });
		            if(chk_value.length == 0)
		            {
		            	dialog_notice('请选择任务接受人！');
		            	tmp = true;
						return false;
		            }
					<?php else: ?>
					var assignedId = $('.Task_assignedId option:selected').val();
					if(assignedId == '')
					{
						dialog_notice('请选择任务接受人！');
						tmp = true;
						return false;
					}
					<?php endif;?>
				}
			}

		})
		if(tmp){
			return false;
		}

		$(".Task_imtypeId").each(function(){
			var imtypeId = $(this).find('option:selected').val();
			if(imtypeId == ''){
				dialog_notice('请选择重要类别！');
				tmp = true;
				return false;
			}
		})
		if(tmp){
			return false;
		}

		$(".Task_name").each(function(){
			if($(this).val() == ''){
				dialog_notice('请填写任务名称！');
				tmp = true;
				return false;
			}
		})
		if(tmp){
			return false;
		}

		$(".Task_desc").each(function(){
			if($(this).val() == ''){
				dialog_notice('请填写任务说明！');
				tmp = true;
				return false;
			}
		})
		if(tmp){
			return false;
		}

		$(".Task_point").each(function(){
			if($(this).val() == ''){
				dialog_notice('请填写奖励积分！');
				tmp = true;
				return false;
			}

			if(isNaN($(this).val()))
			{
				dialog_notice('请填写正确的奖励积分！');
				tmp = true;
				return false;
			}
		})
		if(tmp){
			return false;
		}

		$(".Task_deadline_type").each(function(){
			var deadline_type = $(this).find('option:selected').val();
			if(deadline_type == '')
			{
				dialog_notice('请选择最后时限类别！');
				tmp = true;
				return false;
			}

			$(".Task_deadline"+deadline_type).each(function(){
				var deadline = $(this).val();

				if(deadline == '')
				{
					dialog_notice('任务最后时限不能为空！');
					tmp = true;
					return false;
				}

				if(!tmp){
					if(deadline_type == 2)
					{
						var r = /^[0-9]*[1-9][0-9]*$/;
						if(isNaN(deadline))
						{
							dialog_notice('任务小时数必须是数字！');
							tmp = true;
							return false;
						}else if(parseInt(deadline) <= 0){
							dialog_notice('任务小时数不能小于0！');
							tmp = true;
							return false;
						}else if(!r.test(deadline)){
							dialog_notice('任务小时数必须是整数！');
							tmp = true;
							return false;
						}
					}else{
						var r = /^(\d{1,4})(-)(\d{1,2})(-)(\d{1,2})$/;
						if(!r.test(deadline)){
							dialog_notice('任务天数必须是正确的日期格式！');
							tmp = true;
							return false;
						}
					}
				}
			})
		})
		if(tmp){
			return false;
		}
    }
</script>
