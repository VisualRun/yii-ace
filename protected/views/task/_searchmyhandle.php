    <?php $data_search = $model->searchmyhandleField();?>
    <?php if(!empty($data_search)):?>
    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'search-form',
        'method'=>'get',
        'action'=>Yii::app()->createUrl($this->route),
        'enableClientValidation'=>false,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions'=>array(
            'class'=>'form-horizontal',
        ),
    )); ?>
    <?php foreach ($data_search as $key => $value):?>
    <?php if($value['type']=='text'):?>
    <div class="control-group col-xs-4 no-padding-left" style="margin-bottom:10px;">
        <label class="col-sm-3 control-label no-padding-right">
            <?php echo $value['name'];?>：
        </label>
        <div class="col-sm-9">
            <input class="form-control" name="<?php echo $key;?>" type="text" value='<?php echo $model->{$key};?>' >
        </div>
    </div>
    <?php elseif($value['type']=='select'):?>
    <div class="control-group col-xs-4 no-padding-left " style="margin-bottom:10px;">
        <label class="col-sm-3 control-label no-padding-right"><?php echo $value['name'];?>：</label>
        <div class="col-sm-9">
            <select class="form-control" name="<?php echo $key;?>" value='<?php echo $model->{$key};?>' >
                <option value=""> 请选择 </option>
                <?php foreach ($value['data'] as $k =>$v):?>
                <option <?php if(isset($_GET[$key]) && is_numeric($_GET[$key]) && $_GET[$key] == $k): ?>selected="selected"<?php endif; ?> value="<?php echo $k;?>">
                    <?php echo $v;?>
                </option>
                <?php endforeach;?>
            </select>
        </div>
    </div>
    <?php elseif($value['type']=='daterange'):?>
    <div class="control-group col-xs-4 no-padding-left" style="margin-bottom:10px;">
        <label class="col-sm-3 control-label no-padding-right"><?php echo $value['name'];?>：</label>
        <div class="col-sm-9" style="padding-left:12px;padding-right:12px;">
            <input type="text" name="start" class="date-picker col-sm-5" value='<?php echo isset($_GET['start'])?$_GET['start']:"";?>' data-date-format="yyyy-mm-dd">
            <span class="col-sm-2">~</span>
            <input type="text" name="end" class="date-picker col-sm-5" value='<?php echo isset($_GET['end'])?$_GET['end']:"";?>' data-date-format="yyyy-mm-dd">
        </div>
    </div>
    <?php endif;?>
    <?php endforeach;?>
    <div class="control-group col-xs-4 no-padding-left" style="margin-bottom:10px;">
        <label class="col-sm-3 control-label no-padding-right"></label>
        <div class="col-sm-9" >
            <button type="submit" class="btn btn-white btn-default btn-round">
                <i class="ace-icon glyphicon glyphicon-search"></i>
                搜索
            </button>
            <a href="javascript:void(0)" onclick="location.href='<?php echo Yii::app()->createUrl($this->route); ?>'" class="btn btn-white btn-default btn-round">
                <i class="ace-icon glyphicon glyphicon-repeat red2"></i>
                重置
            </a>
        </div>
    </div>
    <?php $this->endWidget(); ?>
    <?php endif;?>
    <script>
        jQuery(function($) {
            $('.date-picker').datepicker({
                autoclose: true,
                todayHighlight: true,
                language: 'zh-CN'
            });
        })
    </script>