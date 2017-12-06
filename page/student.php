<?php

namespace xavoc\formwala;

class page_student extends \xepan\base\Page{
		
		function init(){
			parent::init();

			$crud = $this->add('xepan\hr\CRUD');
			$crud->setModel('xavoc\formwala\Applicant');
		}	
}