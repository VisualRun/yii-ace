<div class="col-xs-12">
    <script>
        function getUrl(){
            var start = $('#start').val();
            var end = $('#end').val();
            if(start != '' && end != '')
            {
                window.location.href = "index.php?r=admin/point&start="+start+"&end="+end;
            }else{
                alert('请先选择时间！');
            }
        }
    </script>
    <div class="row">
        <div class="control-group col-xs-4 no-padding-left" style="margin-bottom:10px;">
            <label class="col-sm-3 control-label no-padding-right">选择时间：</label>
            <div class="col-sm-9">
                <input id="start" name="start" class="date-picker  col-sm-5" data-date-format='yyyy-mm-dd' value="<?php echo $start ?>" />
                <span class="col-sm-2">~</span>
                <input id="end" name="end" class="date-picker  col-sm-5" data-date-format='yyyy-mm-dd' value="<?php echo $end ?>" />
            </div>
        </div>
        <div class="control-group col-xs-4 no-padding-left" style="margin-bottom:10px;">
            <label class="col-sm-3 control-label no-padding-right"></label>
            <div class="col-sm-9">
                <button class="btn btn-white btn-default btn-round" onclick="getUrl();">
                    <i class="ace-icon glyphicon glyphicon-search"></i>
                    搜索
                </button>
                <a href="javascript:void(0)" onclick="location.href='<?php echo Yii::app()->createUrl($this->route); ?>'" class="btn btn-white btn-default btn-round">
                    <i class="ace-icon glyphicon glyphicon-repeat red2"></i>
                    重置
                </a>
            </div>
        </div>
    </div>
    <hr>
    <?php if(!empty($start) && !empty($end)): ?>
    <div class="row">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="smaller">
                    <?php echo $start ?>至<?php echo $end ?> 期间积分统计情况
                    <small>列出选择的时间段中不同用户所得积分</small>
                </h4>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="profile-user-info profile-user-info-striped">
                        <?php if(!empty($point_arr)): ?>
                        <?php foreach($point_arr as $k => $v): ?>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> 账号 </div>

                            <div class="profile-info-value">
                                 <?php echo $v['account'] ?>
                            </div>
                            <div class="profile-info-name"> 积分 </div>

                            <div class="profile-info-value">
                                 <?php echo $v['point'] ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> &nbsp;&nbsp;&nbsp;&nbsp; </div>

                            <div class="profile-info-value">
                                <?php echo $start ?>至<?php echo $end ?> 期间没有用户有积分增减记录
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if(!empty($point_arr)): ?>
                    <hr>
                    <button class="btn btn-white btn-default btn-round" onclick="window.location.href='index.php?r=admin/point&start=<?php echo $start ?>&end=<?php echo $end ?>&type=excel'">
                        <i class="ace-icon  fa fa-floppy-o"></i>
                        导出记录
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>