<div class="col-xs-12">
	<!-- PAGE CONTENT BEGINS -->
	<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'new-form',
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
			<div class="form-group">
				<?php echo $form->labelEx($model,$key,array('class'=>'col-sm-2 control-label no-padding-right')); ?>
				<div class="col-sm-5">
					<?php echo $form->textField($model,$key,array('class'=>'date-picker','data-date-format'=>'yyyy-mm-dd')); ?>
				</div>
				<?php echo $form->error($model,$key); ?>
			</div>
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

<script type="text/javascript">

	$(function(){
		// $('.id-input-file').ace_file_input({
		// 	no_file:'没有文件 ...',
		// 	btn_choose:'选择本地文件',
		// 	btn_change:'修改',
		// 	droppable:false,
		// 	onchange:null,
		// 	thumbnail:false //| true | large
		// 	//whitelist:'gif|png|jpg|jpeg'
		// 	//blacklist:'exe|php'
		// 	//onchange:''
		// 	//
		// });

		// Dropzone.autoDiscover = false;
		// try {
		//   var myDropzone = new Dropzone("#new-form" , {
		//     paramName: "attach", // The name that will be used to transfer the file
		//     maxFilesize: 0.5, // MB
		
		// 	addRemoveLinks : true,
		// 	dictDefaultMessage :
		// 	'<span class="bigger-150 bolder"><i class="ace-icon fa fa-caret-right red"></i> Drop files</span> to upload \
		// 	<span class="smaller-80 grey">(or click)</span> <br /> \
		// 	<i class="upload-icon ace-icon fa fa-cloud-upload blue fa-3x"></i>'
		// ,
		// 	dictResponseError: 'Error while uploading file!',
			
		// 	//change the previewTemplate to use Bootstrap progress bars
		// 	previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-details\">\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n    <div class=\"dz-size\" data-dz-size></div>\n    <img data-dz-thumbnail />\n  </div>\n  <div class=\"progress progress-small progress-striped active\"><div class=\"progress-bar progress-bar-success\" data-dz-uploadprogress></div></div>\n  <div class=\"dz-success-mark\"><span></span></div>\n  <div class=\"dz-error-mark\"><span></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n</div>"
		//   });
		// } catch(e) {
		//   alert('Dropzone.js does not support older browsers!');
		// }

		$('.date-picker').datepicker({
			autoclose: true,
			todayHighlight: true,
			language: 'zh-CN'
		});

		$('textarea[class*=autosize]').autosize({append: "\n"});
		$('textarea.limited').inputlimiter({
			remText: '%n 字符剩余...',
			limitText: '最多允许 : %n.'
		});

		function showErrorAlert (reason, detail) {
			var msg='';
			if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
			else {
				//console.log("error uploading file", reason, detail);
			}
			$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+
			 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
		}

		$('.wysiwyg-editor').ace_wysiwyg({
			toolbar:
			[
				'font',
				null,
				'fontSize',
				null,
				{name:'bold', className:'btn-info'},
				{name:'italic', className:'btn-info'},
				{name:'strikethrough', className:'btn-info'},
				{name:'underline', className:'btn-info'},
				null,
				{name:'insertunorderedlist', className:'btn-success'},
				{name:'insertorderedlist', className:'btn-success'},
				{name:'outdent', className:'btn-purple'},
				{name:'indent', className:'btn-purple'},
				null,
				{name:'justifyleft', className:'btn-primary'},
				{name:'justifycenter', className:'btn-primary'},
				{name:'justifyright', className:'btn-primary'},
				{name:'justifyfull', className:'btn-inverse'},
				null,
				{name:'createLink', className:'btn-pink'},
				{name:'unlink', className:'btn-pink'},
				null,
				{name:'insertImage', className:'btn-success'},
				null,
				'foreColor',
				null,
				{name:'undo', className:'btn-grey'},
				{name:'redo', className:'btn-grey'}
			],
			'wysiwyg': {
				fileUploadError: showErrorAlert
			}
		}).prev().addClass('wysiwyg-style2');
	})
</script>