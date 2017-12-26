<?php

namespace xavoc\formwala;

class Tool_Carousel extends \xepan\cms\View_Tool{
	public $options = [
			'display_type'=>'slideshow',

		];

	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;
		
		if(!$this->options['carousel_category']){
			$this->add('View')->set('Please Select Carousel Category');
			return;
		}
		$this->image_model = $this->add('xepan\cms\Model_CarouselImage');
		$this->image_model->addCondition([['carousel_category_id',$this->options['carousel_category']],['carousel_category',$this->options['carousel_category']]]);
		$this->image_model->setOrder('order','asc');
		
		switch ($this->options['display_type']) {
				case 'slideshow':
					$this->slideShow();
					break;
				case 'brandCarousel':
					$this->brandCarousel();
					break;
				case 'testimonial':
					$this->testimonial();
					break;
			}
	}

	function slideShow(){

		$this->slide_effect = ['fadetotopfadefrombottom','zoomout','zoomin'];

		$carousel_cl = $this->add('CompleteLister',null,null,['view\tool\carousel']);
		$carousel_cl->setModel($this->image_model);
		
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

	function brandCarousel(){
		$carousel_cl = $this->add('CompleteLister',null,null,['view\tool\carouselmulti']);
		$carousel_cl->setModel($this->image_model);

		$carousel_cl->addHook('formatRow',function($l){
			$l->current_row['file'] = './websites/'.$this->app->current_website_name."/".$l->model['file_id'];
			$l->current_row_html['description']	 = $l->model['text_to_display'];
		});
	}

	function testimonial(){
		$carousel_cl = $this->add('CompleteLister',null,null,['view\tool\carouseltestimonial']);
		$carousel_cl->setModel($this->image_model);

		$carousel_cl->addHook('formatRow',function($l){
			$l->current_row['file'] = './websites/'.$this->app->current_website_name."/".$l->model['file_id'];
			$l->current_row_html['description']	 = $l->model['text_to_display'];
		});
	}
}