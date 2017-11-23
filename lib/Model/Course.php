<?php

namespace xavoc\formwala;

class Model_Course extends \xepan\base\Model_Table{
	public $table = 'course';
	public $status = ['Active','InActive'];
	public $actions = [
					'Active'=> ['view','edit','delete','deactivate'],
					'InActive'=> ['view','edit','delete','activate']
					];

	function init(){
		parent::init();

		$this->addField('course_name');
		$this->addField('status')->enum(['Active','InActive'])->defaultValue('Active');
		$this->hasMany('xavoc\formwala\College','college_name');
	}
}