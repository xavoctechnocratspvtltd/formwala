<?php

namespace xavoc\formwala;

class page_course extends \xepan\base\Page{
		public $title = "Cousre Management";
		function init(){
			parent::init();
			
			$crud = $this->add('xepan\hr\CRUD');
			$crud->setModel('xavoc\formwala\Course');
			$crud->grid->removeAttachment();

			$crud->grid->addPaginator($ipp=50);
			$crud->grid->addQuickSearch(['name']);

			$crud->grid->addHook('formatRow',function($g){
				$g->current_row_html['image'] = '<img style="width:100px;" src="'.$g->model['image'].'" />';
			});
		}	
}