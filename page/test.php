<?php

namespace xavoc\formwala;

class page_test extends \xepan\base\Page{
	
	function init(){
		parent::init();

		$o = $this->add('GiTemplate')->loadTemplate('view/fileupload')->set('url',$this->app->url())->render();
		// echo htmlentities($o);
	}	
}