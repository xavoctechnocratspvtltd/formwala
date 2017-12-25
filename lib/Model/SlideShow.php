<?php

namespace xavoc\formwala;

class Model_SlideShow extends \xepan\cms\Model_CarouselCategory{

	function init(){
		parent::init();

		if(!$this->options['carousel_category'])			
			return;
		
	}
}