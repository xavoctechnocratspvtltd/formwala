<?php

namespace xavoc\formwala;

class Model_College extends \xepan\base\Model_Contact{
	public $title_field = "first_name";
	public $status = ['Active','InActive'];
	public $actions = [
					'Active'=> ['view','college_association','edit','delete','deactivate'],
					'InActive'=> ['view','college_association','edit','delete','activate']
					];
	
	public $type = "College";

	function init(){
		parent::init();

		$this->addCondition('type','College');
		$this->addCondition('created_by_id',$this->app->auth->model->id);

		// field to remove
		$field_remove = ['assign_to_id','last_name','post','source','score','assign_at','freelancer_type','related_with','related_id','updated_at','image_id','remark'];
		foreach ($field_remove as $key => $field) {
			$this->getElement($field)->destroy();
		}

		$this->getElement('first_name')->caption('College Name');
		$this->getElement('created_at')->system(true);
		$this->getElement('status')->defaultValue('Active');
	}

	function page_college_association($page){
		$model = $this->add('xavoc\formwala\Model_CollegeCourseAssociation');
		$model->addCondition('college_id',$this->id);

		$crud = $page->add('xepan\base\CRUD');
		if($crud->isEditing('Add')){
			$form = $crud->form;
			$form->getElement('course_id')->getModel()->addCondition('status','Active');
		}

		$crud->setModel($model);
		$crud->grid->addPaginator($ipp=30);
		$crud->grid->addQuickSearch(['course','college']);
	}

}