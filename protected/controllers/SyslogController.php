<?php

class SyslogController extends Controller
{
	public function init(){
		parent::init();
		$this->modelClass = 'SysLog';
	}
}