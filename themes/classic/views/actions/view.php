<div class="col-xs-12">
    <div class="profile-user-info profile-user-info-striped">
        <?php $arr = $model->viewField();?>
        <?php if(!empty($arr)):?>
        <?php foreach ($arr as $key => $value):?>
        <div class="profile-info-row">
            <div class="profile-info-name"> <?php echo $value ?> </div>

            <div class="profile-info-value">
                <?php echo $model->$key ?>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>