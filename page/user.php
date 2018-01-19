<?php

namespace xavoc\formwala;

class page_user extends \xepan\base\Page{
	public $title = "User";
	function init(){
		parent::init();

		$model = $this->add('xepan\base\Model_User');
		$crud = $this->add('xepan\base\CRUD');
		$crud->setModel($model);
	}	
}