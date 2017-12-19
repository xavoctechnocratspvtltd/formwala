<?php

namespace xavoc\formwala;

class Model_Link extends \xavoc\formwala\Model_Course{

	function init(){
		parent::init();

		$this->addCondition('is_link',true);
			
		$this->is(['link|to_trim|required']);
	}
}