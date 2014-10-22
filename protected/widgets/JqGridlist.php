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

	protected function renderContent()
	{

		$jsonGridSettings = $this->processingGridSettings($this->gridSettings);
		$jsonPagerSettings = $this->processingPagerSettings($this->pagerSettings);
		// echo $jsonGridSettings;
		// echo $jsonPagerSettings;
		// exit;

		$this->render('jqgridlist',
			array(
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

        $gridSettings['url'] = Yii::app()->createUrl($this->model.'/request');
        $gridSettings['datatype'] = 'json';
        $gridSettings['mtype'] = 'POST';
        $gridSettings['height'] = '250';
        $gridSettings['viewrecords'] = true;
        $gridSettings['altRows'] = true;
        $gridSettings['multiselect'] = true;
        $gridSettings['multiboxonly'] = true;
        $gridSettings['autowidth'] = true;
        $gridSettings['loadonce'] = true;

        if ($this->enablePager) {
            $gridSettings['pager'] = "#grid-pager";
        }
        if ($this->enableCellEdit) {
            $gridSettings['cellEdit'] = true;
            $gridSettings['cellurl'] = Yii::app()->createUrl($this->model.'/edit');
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
            'view' => false
        ];
        foreach ($pagerUserSettings as $optionName => $optionSettings) {
            if ($optionSettings === false) {
                continue;
            } elseif ($optionSettings === true) {
                $optionSettings = [];
            }

            switch ($optionName) {
                case 'edit':
                    $editSettings['url'] = Yii::app()->createUrl($this->model.'/edit');
                    $pagerOptions['edit'] = array_merge($editSettings, $optionSettings);
                    break;
                case 'add':
                    $addSettings['url'] = Yii::app()->createUrl($this->model.'/add');
                    $pagerOptions['add'] = array_merge($addSettings, $optionSettings);
                    break;
                case 'del':
                    $delSettings['url'] = Yii::app()->createUrl($this->model.'/del');
                    $pagerOptions['del'] = array_merge($delSettings, $optionSettings);
                    break;
                case 'search':
                    $pagerOptions['search'] = $optionSettings;
                    break;
                case 'view':
                    $pagerOptions['view'] = $optionSettings;
                    break;
                default:
                    throw new InvalidParamException("Invalid param `$optionName` in pager settings");
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
        $resultOptions = json_encode($resultOptions, YII_DEBUG ? JSON_PRETTY_PRINT : 0);

        array_unshift($resultSettings, $resultOptions);
        return implode(',' . PHP_EOL, $resultSettings);
    }

    protected function processingFilterToolbarSettings($filterToolbarSettings)
    {
        return json_encode($filterToolbarSettings, YII_DEBUG ? JSON_PRETTY_PRINT : 0);
    }
}