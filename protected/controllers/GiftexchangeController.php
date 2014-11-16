<?php

class GiftexchangeController extends Controller
{
	public function init(){
		parent::init();
		$this->modelClass = 'GiftExchange';
	}
}