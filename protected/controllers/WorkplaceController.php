<?php

class DeptmentController extends Controller
{
	public function init(){
		parent::init();
		$this->modelClass = 'Workplace';
	}
}