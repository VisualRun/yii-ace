<?php
Yii::import('zii.widgets.grid.CGridView');

class JqGridView extends CGridView
{

	/** @var bool $enablePager */
    public $enablePager = true;

    /** @var bool $enableFilterToolbar */
    public $enableFilterToolbar = false;

    /** @var bool $enableCellEdit */
    public $enableCellEdit = false;

    /** @var array $gridSettings */
    public $gridSettings = array();

    /** @var array $pagerSettings */
    public $pagerSettings = array();

    /** @var array $filterToolbarSettings */
    public $filterToolbarSettings = array();

	public function init()
    {

    	$jsonGridSettings = $this->processingGridSettings($this->gridSettings);
    	

    	//-------------------------------------------------------------------\\
        if ($this->dataProvider === null)
            throw new CException(Yii::t('zii', 'The "dataProvider" property cannot be empty.'));
        $dp = $this->dataProvider;
        $pageVar = $dp->pagination->pageVar;
        /**
         * 核心问题就是用POST过来的当前页面重设掉get过来的当前页面！
         */
        if (isset($_POST['pageNum'])) {
            $_GET[$pageVar] = $_POST['pageNum'];
        }

        //-------------------------------------------------------------------//
        parent::init();
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

        return Json::encode($gridSettings, YII_DEBUG ? JSON_PRETTY_PRINT : 0);
    }
}
?>