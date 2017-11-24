<?php

namespace xavoc\formwala;

class Model_Course extends \xepan\base\Model_Table{
	public $table = 'course';
	public $status = ['Active','InActive'];
	public $actions = [
					'Active'=> ['view','edit','delete','deactivate'],
					'InActive'=> ['view','edit','delete','activate']
					];
	
	public $acl_type = "formwala_course";

	function init(){
		parent::init();

		$this->addField('name');
		$this->addField('status')->enum(['Active','InActive'])->defaultValue('Active');
		$this->hasMany('xavoc\formwala\College','college_name');
	}
}