<?php

namespace xavoc\formwala;

class Model_Student extends \xepan\base\Model_Contact{
	public $status = ['Active','InActive'];
	public $actions = [
					'Active'=> ['view','edit','delete','deactivate'],
					'InActive'=> ['view','edit','delete','activate']
					];
	// public $type = "Student";
	public $acl_type = "formwala_student";

	function init(){
		parent::init();

		$stu_j = $this->join('student.contact_id');
		
		// $stu_j->addField('status')->defaultValue('Active');
	}
}