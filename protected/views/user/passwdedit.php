<div class="col-xs-12">
    <div class="user-profile row">
    <div class="col-sm-offset-1 col-sm-10">
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'passwd-form',
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array(
            'class'=>'form-horizontal',
        ),
    )); ?>
    <div class="tabbable">
        <ul class="nav nav-tabs padding-16">
            <li class="active">
                <a data-toggle="tab" href="#edit-password">
                    <i class="blue ace-icon fa fa-key bigger-125"></i>
                    修改密码
                </a>
            </li>
        </ul>
        <div class="tab-content profile-edit-tab-content">
            <div id="edit-password" class="tab-pane active">
                <div class="space-10"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-pass1">新的密码</label>

                    <div class="col-sm-9">
                        <?php echo $form->passwordField($model,'password',array('id'=>'form-field-pass1')); ?>
                    </div>
                </div>
                <div style="clear:both;"></div>
                <div class="space-4"></div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-pass2">确认密码</label>

                    <div class="col-sm-9">
                        <?php echo $form->passwordField($model,'password',array('id'=>'form-field-pass2')); ?>
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
    </div>
    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button type="submit" class="btn btn-info">
                <i class="ace-icon fa fa-check bigger-110"></i>
                保存
            </button>

            &nbsp; &nbsp;
            <button type="reset" class="btn">
                <i class="ace-icon fa fa-undo bigger-110"></i>
                重置
            </button>
        </div>
    </div>
    <?php $this->endWidget(); ?>
    </div>
    </div>
</div>