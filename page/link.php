<?php

namespace xavoc\formwala;

class page_link extends \xepan\base\Page{
		public $title = "Link Management";
		function init(){
			parent::init();
			
			$crud = $this->add('xepan\base\CRUD');
			$crud->setModel('xavoc\formwala\Link');
			$crud->grid->removeAttachment();

			$crud->grid->addPaginator($ipp=50);
			$crud->grid->addQuickSearch(['name']);

			$crud->grid->addHook('formatRow',function($g){
				$g->current_row_html['image'] = '<img style="width:100px;" src="'.$g->model['image'].'" />';
			});
		}	
}