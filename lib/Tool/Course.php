<?php

namespace xavoc\formwala;

class Tool_Course extends \xepan\cms\View_Tool{
	public $options = [
			'account_page'=>'step1'
		];

	function init(){
		parent::init();

		if($this->owner instanceof \AbstractController) return;

		$model = $this->add('xavoc\formwala\Model_Course');
		$model->addCondition('status','Active');

		$this->complete_lister = $cl = $this->add('CompleteLister',null,null,['view/tool/formwala/course']);
		//not record found
		if(!$model->count()->getOne())
			$cl->template->set('not_found_message','No Record Found');
		else
			$cl->template->del('not_found');

		$cl->setModel($model);

		$cl->add('xepan\cms\Controller_Tool_Optionhelper',['options'=>$this->options,'model'=>$model]);
	}

	function addToolCondition_row_account_page($value,$l){
		$url = $this->api->url($this->options['account_page'],['course'=>$l->model['id']]);
		$l->current_row_html['url'] = $url;
	}

}