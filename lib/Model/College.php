<?php

namespace xavoc\formwala;

class Model_College extends \xepan\base\Model_Table{
	public $table = 'college';
	public $status = ['Active','InActive'];
	public $actions = [
					'Active'=> ['view','edit','delete','deactivate'],
					'InActive'=> ['view','edit','delete','activate']
					];
	
	public $acl_type = "formwala_college";

	function init(){
		parent::init();

		$this->addField('name');
		$this->addField('status')->enum(['Active','InActive'])->defaultValue('Active');
	}
}