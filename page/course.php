<?php

namespace xavoc\formwala;

class page_course extends \xepan\base\Page{
		
		function init(){
			parent::init();
			
			$this->add('xepan\hr\CRUD')->setModel('xavoc\formwala\Course');
			
		}	
}