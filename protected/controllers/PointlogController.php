<?php

class PointlogController extends Controller
{
	public function init(){
		parent::init();
		$this->modelClass = 'PointLog';
	}
}