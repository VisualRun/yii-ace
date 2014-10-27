<?php

class FileController extends Controller
{
	public function init(){
		parent::init();
		$this->modelClass = 'File';
	}
}