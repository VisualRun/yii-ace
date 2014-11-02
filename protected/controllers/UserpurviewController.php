<?php

class UserpurviewController extends Controller
{
	public function init(){
		parent::init();
		$this->modelClass = 'UserPurview';
	}
}