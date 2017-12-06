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

		$stu_j->hasOne('xavoc\formwala\Course','course_id')->display(array('form' => 'xepan\commerce\DropDown'));
		$stu_j->hasOne('xavoc\formwala\College','first_college_id')->display(array('form' => 'xepan\commerce\DropDown'));
		$stu_j->hasOne('xavoc\formwala\College','secord_college_id')->display(array('form' => 'xepan\commerce\DropDown'));
		$stu_j->hasOne('xavoc\formwala\College','third_college_id')->display(array('form' => 'xepan\commerce\DropDown'));

		$stu_j->hasOne('xepan\base\Country','local_country_id')->display(array('form' => 'xepan\commerce\DropDown'));
		$stu_j->hasOne('xepan\base\State','local_state_id')->display(array('form' => 'xepan\commerce\DropDown'));
				
		$stu_j->addField('local_city');
		$stu_j->addField('local_address');
		$stu_j->addField('local_pin_code');

		$stu_j->addField('middle_name');

		$stu_j->addField('mobile_no');
		$stu_j->addField('email_id');
		$stu_j->addField('dob')->caption('Date of Birth');
		$stu_j->addField('gender')->enum(['Male','Female','Other']);
		$stu_j->addField('marital_status')->enum(['single','married']);
		$stu_j->addField('blood_group');

		$stu_j->addField('guardian_name')->caption('Father\'s/Husband\'s Name');
		$stu_j->addField('occupation_of_guardian');
		$stu_j->addField('annual_family_income');
		$stu_j->addField('guardian_contact_no');

		// educational detail 
		 // 1
		$stu_j->addField('course_1')->caption('Course');
		$stu_j->addField('name_of_institute_1')->caption('Education Name of College / Institute');
		$stu_j->addField('board_university_1')->caption('Board / University');
		$stu_j->addField('year_1')->caption('Year');
		$stu_j->addField('percentage_of_marks_1')->caption('% of Marks');
		$stu_j->addField('special_subjects_1')->caption('Special / Optional Subjects');

		// 2
		$stu_j->addField('course_2')->caption('Course');
		$stu_j->addField('name_of_institute_2')->caption('Education Name of College / Institute');
		$stu_j->addField('board_university_2')->caption('Board / University');
		$stu_j->addField('year_2')->caption('Year');
		$stu_j->addField('percentage_of_marks_2')->caption('% of Marks');
		$stu_j->addField('special_subjects_2')->caption('Special / Optional Subjects');

		// 3
		$stu_j->addField('course_3')->caption('Course');
		$stu_j->addField('name_of_institute_3')->caption('Education Name of College / Institute');
		$stu_j->addField('board_university_3')->caption('Board / University');
		$stu_j->addField('year_3')->caption('Year');
		$stu_j->addField('percentage_of_marks_3')->caption('% of Marks');
		$stu_j->addField('special_subjects_3')->caption('Special / Optional Subjects');
		
		// 4
		$stu_j->addField('course_4')->caption('Course');
		$stu_j->addField('name_of_institute_4')->caption('Education Name of College / Institute');
		$stu_j->addField('board_university_4')->caption('Board / University');
		$stu_j->addField('year_4')->caption('Year');
		$stu_j->addField('percentage_of_marks_4')->caption('% of Marks');
		$stu_j->addField('special_subjects_4')->caption('Special / Optional Subjects');

		// 5
		$stu_j->addField('course_5')->caption('Course');
		$stu_j->addField('name_of_institute_5')->caption('Education Name of College / Institute');
		$stu_j->addField('board_university_5')->caption('Board / University');
		$stu_j->addField('year_5')->caption('Year');
		$stu_j->addField('percentage_of_marks_5')->caption('% of Marks');
		$stu_j->addField('special_subjects_5')->caption('Special / Optional Subjects');

		// 6
		$stu_j->addField('course_6')->caption('Course');
		$stu_j->addField('name_of_institute_6')->caption('Education Name of College / Institute');
		$stu_j->addField('board_university_6')->caption('Board / University');
		$stu_j->addField('year_6')->caption('Year');
		$stu_j->addField('percentage_of_marks_6')->caption('% of Marks');
		$stu_j->addField('special_subjects_6')->caption('Special / Optional Subjects');

		// 7
		$stu_j->addField('course_7')->caption('Course');
		$stu_j->addField('name_of_institute_7')->caption('Education Name of College / Institute');
		$stu_j->addField('board_university_7')->caption('Board / University');
		$stu_j->addField('year_7')->caption('Year');
		$stu_j->addField('percentage_of_marks_7')->caption('% of Marks');
		$stu_j->addField('special_subjects_7')->caption('Special / Optional Subjects');

		// 8
		$stu_j->addField('course_8')->caption('Course');
		$stu_j->addField('name_of_institute_8')->caption('Education Name of College / Institute');
		$stu_j->addField('board_university_8')->caption('Board / University');
		$stu_j->addField('year_8')->caption('Year');
		$stu_j->addField('percentage_of_marks_8')->caption('% of Marks');
		$stu_j->addField('special_subjects_8')->caption('Special / Optional Subjects');


		$this->getElement('address')->caption('Permanent Address');
		$this->getElement('status')->defaultValue('Active');

		$this->addCondition('type','Applicant');
	}
}