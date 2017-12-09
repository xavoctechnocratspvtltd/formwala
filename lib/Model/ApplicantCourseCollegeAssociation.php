<?php

namespace xavoc\formwala;

class Model_ApplicantCourseCollegeAssociation extends \xepan\base\Model_Table{
	
	public $acl = false;
	public $table = 'formwala_applicant_course_college_asso';
	public $status = [];
	public $actions = [
					'All'=>['view','edit','delete']
					];

	function init(){
		parent::init();
		
		$this->hasOne('xavoc\formwala\Model_College','college_id');
		$this->hasOne('xavoc\formwala\Model_Course','course_id');
		$this->hasOne('xavoc\formwala\Model_Applicant','applicant_id');

		$this->addField('created_at')->type('datetime')->defaultValue($this->app->now);
	}

}