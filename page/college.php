<?php

namespace xavoc\formwala;

class page_college extends \xepan\base\Page{
	public $title = "College Management";

	function init(){
		parent::init();
		
		$crud = $this->add('xepan\hr\CRUD');
		$model = $this->add('xavoc\formwala\Model_College');
		if($crud->isEditing()){
			$form = $crud->form;
			$form->add('xepan\base\Controller_FLC')
				->addContentSpot()
				->makePanelsCoppalsible(true)
				->layout([
					'first_name~Name'=>'College Detail~c1~12',
					'address'=>'c2~4',
					'city'=>'c3~4',
					'state_id'=>'c3~4',
					'country_id'=>'c3~4',
					'pin_code'=>'c4~4',
					'website'=>'c4~4',
				])
				;
		}

		$crud->setModel($model,['first_name','address','city','state_id','country_id','pin_code','website']);
		$crud->grid->removeAttachment();
	}	
}