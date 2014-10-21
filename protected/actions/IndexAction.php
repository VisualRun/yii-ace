<?php

/**
 * crud重用
 */
class IndexAction extends CAction{  
	public $modelClass = '';
    public $renderTo = '/actions/index';  
    public $searchName = 'search';  
    public function run(){
    	$obj = $this->modelClass;
        $model=new $obj($this->searchName);
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET))
            $model->attributes=$_GET;
        $this->getController()->render($this->renderTo,array('model'=>$model));
    }  
}