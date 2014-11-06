<div class="col-xs-12">
    <script>
        function getUrl(){
            var monthyear = $('#monthYear').val();
            if(monthyear != '')
            {
                window.location.href = "index.php?r=admin/point&month="+monthyear;
            }
        }
    </script>
    <div class="row">
        <div class="control-group col-xs-4 no-padding-left" style="margin-bottom:10px;">
            <label class="col-sm-3 control-label no-padding-right">选择年月：</label>
            <div class="col-sm-9">
                <input id="monthYear" name="monthYear" class="date-picker form-control" data-date-format='yyyy-mm' value="<?php echo $monthYear ?>" readonly="true" />
            </div>
        </div>
        <div class="control-group col-xs-4 no-padding-left" style="margin-bottom:10px;">
            <label class="col-sm-3 control-label no-padding-right"></label>
            <div class="col-sm-9">
                <button class="btn btn-white btn-default btn-round" onclick="getUrl();">
                    <i class="ace-icon glyphicon glyphicon-search"></i>
                    搜索
                </button>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="smaller">
                    <?php echo $monthYear ?> 月份积分统计情况
                    <small>列出该月中不同用户所得积分</small>
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
                                <?php echo $monthYear ?>月份 没有用户有积分增减记录
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if(!empty($point_arr)): ?>
                    <hr>
                    <button class="btn btn-white btn-default btn-round" onclick="window.location.href='index.php?r=admin/point&month=<?php echo $monthYear ?>&type=excel'">
                        <i class="ace-icon  fa fa-floppy-o"></i>
                        导出月份记录
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>