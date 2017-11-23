<?php

namespace xavoc\formwala;

class Model_Student extends \xepan\base\Model_Table{
	public $table = 'student';
	public $status = ['Active','InActive'];
	public $actions = [
					'Active'=> ['view','edit','delete','deactivate'],
					'InActive'=> ['view','edit','delete','activate']
					];
	
	function init(){
		parent::init();

		$this->addField('first_name');
		$this->addField('last_name');
		$this->addField('address');
		$this->addField('status')->enum(['Active','InActive'])->defaultValue('Active');

		$this->hasOne('xavoc\formwala\College','college_name');
		
		$this->hasMany('xavoc\formwala\Course','course_name');

	}
}