<div class="col-xs-12">
    <?php foreach($model as $k=>$v): ?>
    <?php $submodel = Task::model()->findByPk($v->id); ?>
    <?php $file = File::model()->findAll("taskId = $v->id"); ?>
    <?php $realdeadline = Helpers::realdeadline($submodel);  ?>
    <h4 class="widget-title lighter smaller">
        <i class="ace-icon fa fa-tasks blue"></i>&nbsp;&nbsp;
        <strong><a title="进入任务详情" href="<?php echo Yii::app()->createUrl('/task/view',array('id'=>$v->id));  ?>" ><?php echo $submodel->name ?></a></strong>
    </h4>
    <div class="profile-user-info profile-user-info-striped">
        <div class="profile-info-row">
            <div class="profile-info-name"> 任务编码 </div>

            <div class="profile-info-value">
                <?php echo $submodel->code ?>
            </div>
            <div class="profile-info-name"> 状态 </div>

            <div class="profile-info-value">
                <?php echo Yii::app()->params['task_status'][$submodel->status] ?>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name"> 任务类别 </div>

            <div class="profile-info-value">
                <?php echo Yii::app()->params['task_type'][$submodel->typeId] ?>
            </div>
            <div class="profile-info-name"> 重要类别 </div>

            <div class="profile-info-value">
                <?php echo Yii::app()->params['task_important_type'][$submodel->imtypeId] ?>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name"> 创建人 </div>

            <div class="profile-info-value">
                <?php echo $submodel->opened->account ?>
            </div>
            <div class="profile-info-name"> 创建时间 </div>

            <div class="profile-info-value">
                <?php echo $submodel->openedDate ?>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name"> 奖励积分 </div>

            <div class="profile-info-value">
                <?php echo $submodel->point ?>

            </div>
            <div class="profile-info-name"> 最后期限 </div>

            <div class="profile-info-value">
                <?php if($submodel->deadline_type == 1): ?>
                <?php echo $submodel->deadline; ?>&nbsp;(按天)
                <?php elseif($submodel->deadline_type == 2): ?>
                <?php echo $realdeadline; ?>&nbsp;(按小时)
                <?php endif; ?>
            </div>
        </div>
        <?php if($v->assignedId != 0 && $v->status != 4): ?>
        <div class="profile-info-row">
            <div class="profile-info-name"> 指派给 </div>

            <div class="profile-info-value">
                <?php echo $v->assigned->account ?>
            </div>
            <div class="profile-info-name"> 指派时间 </div>

            <div class="profile-info-value">
                <?php echo $v->assignedDate ?>
            </div>
        </div>
        <div class="profile-info-row">
            <div class="profile-info-name"> 完成时间 </div>

            <div class="profile-info-value">
                <?php echo $v->finishedDate ?>
            </div>
            <div class="profile-info-name"> 确认完成时间 </div>

            <div class="profile-info-value">
                <?php echo $v->closedDate ?>
            </div>
        </div>
        <?php if($v->status == 5): ?>
        <div class="profile-info-row">
            <div class="profile-info-name"> 最后得到积分 </div>

            <div class="profile-info-value">
                <?php echo $v->finishedpoint ?>
            </div>
            <div class="profile-info-name"></div>

            <div class="profile-info-value">
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="space-4"></div>
    <div class="profile-user-info profile-user-info-striped">
        <div class="profile-info-row">
            <div class="profile-info-name"> 任务说明 </div>

            <div class="profile-info-value">
                <?php echo $submodel->desc ?>
            </div>
        </div>
    </div>
    <?php if(!empty($file)): ?>
    <div class="space-4"></div>
        <div class="profile-user-info profile-user-info-striped">
            <div class="profile-info-row">
                <div class="profile-info-name"> 任务附件 </div>

                <div class="profile-info-value">
                    <?php foreach($file as $k1· => $v1): ?>
                    <a target="_blank" href="<?php echo $v1->pathname; ?>" ><?php echo $v1->title; ?></a>&nbsp;&nbsp;
                    <?php endforeach;?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <br><br>
    <?php endforeach; ?>

</div>