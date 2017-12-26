<?php

namespace xavoc\formwala;

class Tool_Carousel extends \xepan\cms\View_Tool{
	public $options = [];

	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;
		
		if(!$this->options['carousel_category']){
			$this->add('View')->set('Please Select Carousel Category');
			return;
		}
		

		$this->slide_effect = ['fadetotopfadefrombottom','zoomout','zoomin'];


		$image_m = $this->add('xepan\cms\Model_CarouselImage');
		$image_m->addCondition([['carousel_category_id',$this->options['carousel_category']],['carousel_category',$this->options['carousel_category']]]);
		$image_m->setOrder('order','asc');

		$carousel_cl = $this->add('CompleteLister',null,null,['view\tool\carousel']);
		$carousel_cl->setModel($image_m);
		
		$this->app->jquery->addStaticInclude('revolution/js/jquery.themepunch.tools.min');
		$this->app->jquery->addStaticInclude('revolution/js/jquery.themepunch.revolution.min');
		$this->app->jquery->addStaticInclude('owl.carousel.min');

		$this->slide_count = 0;
		$carousel_cl->addHook('formatRow',function($l){
			$l->current_row['file'] = './websites/'.$this->app->current_website_name."/".$l->model['file_id'];
			$l->current_row_html['description']	 = $l->model['text_to_display'];
			$l->current_row_html['slide_transition'] = $this->slide_effect[$this->slide_count];
			
			$this->slide_count++;
			if($this->slide_count > count($this->slide_effect))
				$this->slide_count = 0;
		});

	}
}