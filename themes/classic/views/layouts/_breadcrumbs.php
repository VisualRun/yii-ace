<div class="breadcrumbs breadcrumbs-fixed" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>

    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="<?php  echo $this->createUrl('/home/index'); ?>">首页</a>
        </li>
        <?php if(is_array(Yii::app()->controller->menu_nav)): ?>
        <?php foreach(Yii::app()->controller->menu_nav as $key => $value): ?>
        <li>
            <?php if(isset($value->href)): ?>
            <a href="<?php echo $value->href ?>"><?php echo $value->value ?></a>
            <?php else: ?>
            <?php echo $value->value ?>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
        <?php endif; ?>
        <li class="active"><?php echo $this->pageTitle ?></li>
    </ul><!-- /.breadcrumb -->

    <!-- #section:basics/content.searchbox -->
    <div class="nav-search hide" id="nav-search">
        <form class="form-search">
            <span class="input-icon">
                <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                <i class="ace-icon fa fa-search nav-search-icon"></i>
            </span>
        </form>
    </div><!-- /.nav-search -->
    <!-- /section:basics/content.searchbox -->
</div>