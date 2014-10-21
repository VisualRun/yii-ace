<?php

Yii::import('zii.widgets.CPortlet');

class JqGridlist extends CPortlet
{
	public $pageSize = 10;
	public $model = '';
	public $viewData = [];
	public $caption = '';
	public $requestUrl = '';
	public $enablePager = true;
	public $enableCellEdit = false;
	public $gridSettings = [];
	public $pagerSettings = [];
	public $enableFilterToolbar = true;
	protected function renderContent()
	{

		$jsonGridSettings = $this->processingGridSettings($this->gridSettings);
		$jsonPagerSettings = $this->processingPagerSettings($this->pagerSettings);
		echo $jsonGridSettings;
		echo $jsonPagerSettings;
		exit;

		$this->render('jqgridlist',
			array(
				'model'=>$this->model,
				'pageSize'=>$this->pageSize,
				'viewData'=>$this->viewData,
				'caption'=>$this->caption,
				'gridSettings'=>$this->jsonGridSettings,
				'pagerSettings'=>$this->jsonPagerSettings,
				'enableFilterToolbar'=>$this->enableFilterToolbar,
			)
		);
	}

	protected function processingGridSettings($gridUserSettings)
    {
        $widgetId = $this->id;

        $gridSettings['url'] = $this->requestUrl . '?action=request';
        $gridSettings['datatype'] = 'json';
        $gridSettings['mtype'] = 'POST';
        if ($this->enablePager) {
            $gridSettings['pager'] = "#jqGrid-pager-{$widgetId}";
        }
        if ($this->enableCellEdit) {
            $gridSettings['cellEdit'] = true;
            $gridSettings['cellurl'] = $this->requestUrl . '?action=edit';
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
                    $editSettings['url'] = $this->requestUrl . '?action=edit';
                    $pagerOptions['edit'] = array_merge($editSettings, $optionSettings);
                    break;
                case 'add':
                    $addSettings['url'] = $this->requestUrl . '?action=add';
                    $pagerOptions['add'] = array_merge($addSettings, $optionSettings);
                    break;
                case 'del':
                    $delSettings['url'] = $this->requestUrl . '?action=del';
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