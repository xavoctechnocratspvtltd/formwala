<?php

namespace xavoc\formwala;

class page_college extends \xepan\base\Page{
		
		function init(){
			parent::init();
			
			$this->add('xepan\hr\CRUD')->setModel('xavoc\formwala\College');
			
		}	
}