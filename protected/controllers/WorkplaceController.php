<?php

class WorkplaceController extends Controller
{
	public function init(){
		parent::init();
		$this->modelClass = 'Workplace';
	}
}