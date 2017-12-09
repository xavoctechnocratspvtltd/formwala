<?php

namespace xavoc\formwala;

class Model_CollegeCourseAssociation extends \xepan\base\Model_Table{
	
	public $acl =false;
	public $table = 'formwala_college_course_association';
	public $status = [];
	public $actions = [
					'All'=>['view','edit','delete']
					];

	function init(){
		parent::init();

		$this->hasOne('xavoc\formwala\Model_College','college_id');
		$this->hasOne('xavoc\formwala\Model_Course','course_id');

		$this->addHook('beforeSave',$this);
	}

	function beforeSave(){
		$old = $this->add('xavoc\formwala\Model_CollegeCourseAssociation');
		$old->addCondition('college_id',$this['college_id']);
		$old->addCondition('course_id',$this['course_id']);
		$old->addCondition('id','<>',$this->id);
		$old->tryLoadAny();

		if($old->loaded()){
			throw $this->exception('college already associate with course', 'ValidityCheck')->setField('college_id');
		}
		
	}

}