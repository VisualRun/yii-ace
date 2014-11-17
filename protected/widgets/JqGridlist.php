<?php

Yii::import('zii.widgets.CPortlet');

class JqGridlist extends CPortlet
{
	public $pageSize = 10;
	public $model = '';
	public $viewData = [];
	public $enablePager = true;
	public $enableCellEdit = false;
	public $gridSettings = [];
	public $pagerSettings = [];
	public $enableFilterToolbar = true;
    public $resultType = 'result';
    public $gridType = '';

	protected function renderContent()
	{
        $this->getController()->page_css = array(
            'jquery-ui.min.css',
            'datepicker.css',
            'ui.jqgrid.css',
            );

        $this->getController()->page_js = array(
            'date-time/bootstrap-datepicker.min.js',
            'date-time/locales/bootstrap-datepicker.zh-CN.js',
            'jqGrid/jquery.jqGrid.min.js',
            'jqGrid/i18n/grid.locale-cn.js',
            );
        $this->getController()->page_script = <<<EOD
<script type="text/javascript">
    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true,
        language: 'zh-CN'
    })
</script>
EOD;

		$jsonGridSettings = $this->processingGridSettings($this->gridSettings);
		$jsonPagerSettings = $this->processingPagerSettings($this->pagerSettings);

		$this->render('jqgridlist',
			array(
                'gridType'=>$this->gridType,
				'pageSize'=>$this->pageSize,
				'viewData'=>$this->viewData,
				'gridSettings'=>$jsonGridSettings,
				'pagerSettings'=>$jsonPagerSettings,
				'enableFilterToolbar'=>$this->enableFilterToolbar,
			)
		);
	}

	protected function processingGridSettings($gridUserSettings)
    {
        $widgetId = $this->id;

        //print_r(Helpers::arrparam());exit;

        $gridSettings['url'] = Yii::app()->createUrl($this->model.'/requestjqgrid',array_merge(array('resultType'=>$this->resultType),Helpers::arrparam()));
        $gridSettings['datatype'] = 'json';
        $gridSettings['mtype'] = 'POST';
        $gridSettings['jsonReader'] = ['root'=>'griddata','total'=>"totalpages",'page'=>'currpage','records'=>'totalrecords','repeatitems'=>false];
        $gridSettings['height'] = 326;
        $gridSettings['viewrecords'] = true;
        $gridSettings['altRows'] = true;
        $gridSettings['multiselect'] = true;
        $gridSettings['multiboxonly'] = true;
        $gridSettings['autowidth'] = true;
        $gridSettings['loadonce'] = false;

        if ($this->enablePager) {
            $gridSettings['pager'] = "#grid-pager".$this->gridType;
        }
        if ($this->enableCellEdit) {
            $gridSettings['cellEdit'] = true;
            $gridSettings['cellurl'] = Yii::app()->createUrl($this->model.'/updatejqgrid');
        }
        $gridSettings = array_merge($gridSettings, $gridUserSettings);

        return json_encode($gridSettings, YII_DEBUG ? JSON_PRETTY_PRINT : 0);
    }

    protected function processingPagerSettings($pagerUserSettings)
    {
        $pagerOptions = [
            'edit' => false,
            'add' => false,
            'del' => false,
            'search' => false,
            'refresh' => true,
            'view' => true,
        ];
        foreach ($pagerUserSettings as $optionName => $optionSettings) {
            if ($optionSettings === false) {
                continue;
            } elseif ($optionSettings === true) {
                $optionSettings = [];
            }

            switch ($optionName) {
                case 'edit':
                    $editSettings['url'] = Yii::app()->createUrl($this->model.'/updatejqgrid');
                    $editSettings['closeAfterEdit'] = true;
                    $editSettings['recreateForm'] = true;
                    $editSettings['viewPagerButtons'] = false;
                    $editSettings['reloadAfterSubmit'] = true;
                    $pagerOptions['edit'] = array_merge($editSettings, $optionSettings);
                    break;
                case 'add':
                    $addSettings['url'] = Yii::app()->createUrl($this->model.'/createjqgrid');
                    $addSettings['closeAfterAdd'] = true;
                    $addSettings['recreateForm'] = true;
                    $addSettings['viewPagerButtons'] = false;
                    $addSettings['reloadAfterSubmit'] = true;
                    $pagerOptions['add'] = array_merge($addSettings, $optionSettings);
                    break;
                case 'del':
                    $delSettings['url'] = Yii::app()->createUrl($this->model.'/deljqgrid');
                    $delSettings['recreateForm'] = true;
                    $delSettings['reloadAfterSubmit'] = true;
                    $pagerOptions['del'] = array_merge($delSettings, $optionSettings);
                    break;
                case 'search':
                    $pagerOptions['search'] = $optionSettings;
                    break;
                case 'refresh':
                    $pagerOptions['refresh'] = $optionSettings;
                    break;
                case 'view':
                    $viewSettings['recreateForm'] = true;
                    $viewSettings['viewPagerButtons'] = true;
                    $pagerOptions['view'] = array_merge($viewSettings, $optionSettings);
                    break;
                default:
                    throw new CHttpException("Invalid param `$optionName` in pager settings");
            }
        }

        $resultOptions = [];
        $resultSettings = [];
        foreach ($pagerOptions as $optionName => $optionSettings) {
            if ($optionSettings === false) {
                $resultOptions[$optionName] = false;
                $resultSettings[] = '{}';
            } else {
                $resultOptions[$optionName] = true;
                $resultSettings[] = json_encode($optionSettings, YII_DEBUG ? JSON_PRETTY_PRINT : 0);
            }
        }
        $resultOptions['editicon'] = 'ace-icon fa fa-pencil blue';
        $resultOptions['addicon'] = 'ace-icon fa fa-plus-circle purple';
        $resultOptions['delicon'] = 'ace-icon fa fa-trash-o red';
        $resultOptions['searchicon'] = 'ace-icon fa fa-search orange';
        $resultOptions['refreshicon'] = 'ace-icon fa fa-refresh green';
        $resultOptions['viewicon'] = 'ace-icon fa fa-search-plus grey';

        $resultOptions = json_encode($resultOptions, YII_DEBUG ? JSON_PRETTY_PRINT : 0);

        array_unshift($resultSettings, $resultOptions);
        return implode(',' . PHP_EOL, $resultSettings);
    }

    protected function processingFilterToolbarSettings($filterToolbarSettings)
    {
        return json_encode($filterToolbarSettings, YII_DEBUG ? JSON_PRETTY_PRINT : 0);
    }
}