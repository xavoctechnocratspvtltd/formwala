<?php

namespace xavoc\formwala;

class Model_Applicant extends \xepan\base\Model_Contact{

	public $status = ['Active','InActive'];
	public $actions = [
					'Active'=> ['view','edit','delete','deactivate'],
					'InActive'=> ['view','edit','delete','activate']
					];

	public $type = "Applicant";
	public $acl_type = "formwala_applicant";

	function init(){
		parent::init();

		$stu_j = $this->join('formwala_applicant.contact_id');

		// $stu_j->hasOne('xavoc\formwala\Course','course_id')->display(array('form' => 'xepan\commerce\DropDown'));
		// $stu_j->hasOne('xavoc\formwala\College','first_college_id')->display(array('form' => 'xepan\commerce\DropDown'));
		// $stu_j->hasOne('xavoc\formwala\College','secord_college_id')->display(array('form' => 'xepan\commerce\DropDown'));
		// $stu_j->hasOne('xavoc\formwala\College','third_college_id')->display(array('form' => 'xepan\commerce\DropDown'));

		$stu_j->hasOne('xepan\base\Country','local_country_id')->display(array('form' => 'xepan\commerce\DropDown'));
		$stu_j->hasOne('xepan\base\State','local_state_id')->display(array('form' => 'xepan\commerce\DropDown'));
				
		$stu_j->addField('local_city');
		$stu_j->addField('local_address')->type('text');
		$stu_j->addField('local_pin_code');

		$stu_j->addField('middle_name');

		$stu_j->addField('mobile_no')->type('Number');
		
		$stu_j->addField('email_id');
		$stu_j->addField('dob')->caption('Date of Birth')->type('date');
		$stu_j->addField('gender')->enum(['Male','Female','Other']);
		$stu_j->addField('marital_status')->enum(['single','married']);
		$stu_j->addField('blood_group')->enum(['A+','A-','B+','B-','O+','O-','AB+','AB-']);
		$stu_j->addField('aadhar_no');

		$stu_j->addField('father_name');
		$stu_j->addField('father_contact_no')->type('int');
		$stu_j->addField('occupation_of_father');
		$stu_j->addField('mother_name');
		$stu_j->addField('mother_contact_no');
		$stu_j->addField('occupation_of_mother');

		// educational detail 
		 // 1
		$stu_j->addField('course_1')->caption('Course')->defaultValue('10');
		$stu_j->addField('name_of_institute_1')->caption('Education Name of College / Institute');
		$stu_j->addField('board_university_1')->caption('Board / University');
		$stu_j->addField('year_1')->caption('Year');
		$stu_j->addField('percentage_of_marks_1')->caption('% of Marks');

		// 2
		$stu_j->addField('course_2')->caption('Course')->defaultValue('12');
		$stu_j->addField('name_of_institute_2')->caption('Education Name of College / Institute');
		$stu_j->addField('board_university_2')->caption('Board / University');
		$stu_j->addField('year_2')->caption('Year');
		$stu_j->addField('percentage_of_marks_2')->caption('% of Marks');

		// 3
		$stu_j->addField('course_3')->caption('Course')->defaultValue('Gradutation');
		$stu_j->addField('name_of_institute_3')->caption('Education Name of College / Institute');
		$stu_j->addField('board_university_3')->caption('Board / University');
		$stu_j->addField('year_3')->caption('Year');
		$stu_j->addField('percentage_of_marks_3')->caption('% of Marks');

		// other
		$stu_j->addField('course_4')->caption('Course')->defaultValue('Other');
		$stu_j->addField('name_of_institute_4')->caption('Education Name of College / Institute');
		$stu_j->addField('board_university_4')->caption('Board / University');
		$stu_j->addField('year_4')->caption('Year');
		$stu_j->addField('percentage_of_marks_4')->caption('% of Marks');

		$this->getElement('address')->caption('Permanent Address');
		$this->getElement('status')->defaultValue('Active');

		$this->addCondition('type','Applicant');

		$this->addHook('beforeSave',$this,[],4);
	}

	function beforeSave(){
		if(!$this['first_name']) $this['first_name'] = "Guest";
	}
}