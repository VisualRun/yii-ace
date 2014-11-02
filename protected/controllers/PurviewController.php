<?php

class PurviewController extends Controller
{
	public function init(){
		parent::init();
		$this->modelClass = 'Purview';
	}
}