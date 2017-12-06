<?php

namespace xavoc\formwala;

class Model_Course extends \xepan\base\Model_Table{
	public $table = 'course';
	public $status = ['Active','InActive'];
	public $actions = [
					'Active'=> ['view','college_association','edit','delete','deactivate'],
					'InActive'=> ['view','edit','delete','activate']
					];
	
	public $acl_type = "formwala_course";

	function init(){
		parent::init();

		$this->addField('name');
		$this->addField('status')->enum(['Active','InActive'])->defaultValue('Active');

		$this->hasMany('xavoc\formwala\CollegeCourseAssociation','course_id');
		
		// $this->addHook('beforeSave',$this);
		$this->is(['name|to_trim|required|unique']);
	}

	function page_college_association($page){
		$model = $this->add('xavoc\formwala\Model_CollegeCourseAssociation');
		$model->addCondition('course_id',$this->id);

		$crud = $page->add('xepan\base\CRUD');

		if($crud->isEditing('Add')){
			$form = $crud->form;
			$form->getElement('college_id')->getModel()->addCondition('status','Active');
		}

		$crud->setModel($model);
		$crud->grid->addPaginator($ipp=30);
		$crud->grid->addQuickSearch(['course','college']);

	}


}