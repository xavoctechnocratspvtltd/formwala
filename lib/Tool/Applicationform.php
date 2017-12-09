<?php

namespace xavoc\formwala;

class Tool_Applicationform extends \xepan\cms\View_Tool{
	public $options = [
			'login_page'=>'login'
		];

	public $course;

	function init(){
		parent::init();
		
		if($this->owner instanceof \AbstractController) return;

		$this->course = $course = trim($this->app->stickyGET('course'));
		if(!strlen($course)){
			$this->add('View')->addClass('alert alert-warning')->set('Course is not defined');
			return;
		}
		

		$model = $this->add('xavoc\formwala\Model_Course');
		$model->addCondition('id',$course);
		$model->tryLoadAny();
		if(!$model->loaded()){
			$this->add('View')
				->addClass('alert alert-warning')
				->set('Course is not defined');
			return;
		}

		// check student is login
		if(!$this->app->auth->isLoggedIn()){
			$this->app->redirect($this->app->url($this->options['login_page'],['course_id'=>$course]));
		}

		// if not login then redirect to login page
		// else show registration form

		$active_step = $this->app->stickyGET('step');
		if(!$active_step)
			$active_step = 1;

		$pb = $this->add('xepan\epanservices\View_ProgressBar',['active_step'=>$active_step]);

		switch ($active_step) {
			case '1':
				$this->applicantForm();
				break;
			case '2':
				$this->collegeSelectionForm();
				break;
			case '3':
				$this->finalStep();
				break;
		}
	}

	function applicantForm(){

		$model_applicant = $this->add('xavoc\formwala\Model_Applicant');
		if(!$model_applicant->loadLoggedIn()){
			$this->add('View')->addClass('alert alert-warning')->set('Applicant is not logged in');
			return;
		}

		$field_to_remove = ['created_by_id','assign_to_id','post','website','source','remark','score','assign_at','freelancer_type','related_with','related_id'];
		foreach ($field_to_remove as $field) {
			$model_applicant->getElement($field)->destroy();
		}
		$model_applicant->getElement('created_at')->system(true);
		$model_applicant->getElement('updated_at')->system(true);
		$model_applicant->getElement('organization')->system(true);

		$form = $this->add('Form');
		$form->add('xepan\base\Controller_FLC')
			->makePanelsCoppalsible(true)
			->showLables(true)
			->addContentSpot()
			->layout([
				'first_name'=>'Personal Information~c1~4',
				'middle_name'=>'c2~4',
				'last_name'=>'c3~4',
				'image_id~Profile Picture'=>'c4~4',
				'mobile_no'=>'c5~4',
				'email_id'=>'c6~4',
				'dob'=>'c7~4',
				'gender'=>'c8~4',
				'marital_status'=>'c9~4',
				'blood_group'=>'c10~4',

				'country_id~Country'=>'Permanent Address~c11~4',
				'state_id~State'=>'c12~4',
				'city'=>'c13~4',
				'address'=>'c14~4',
				'pin_code'=>'c15~4',

				'local_country_id~Country'=>'Local Address~c21~4',
				'local_state_id~State'=>'c22~4',
				'local_city~City'=>'c23~4',
				'local_address~Address'=>'c24~4',
				'local_pin_code~Pin Code'=>'c25~4',
				
				'guardian_name'=>'Guardian Detail~c31~3',
				'occupation_of_guardian'=>'c32~3',
				'annual_family_income'=>'c33~3',
				'guardian_contact_no'=>'c34~3',

				'course_1~Course'=>'Educational Details~c41~2',
				'name_of_institute_1~College / Institute'=>'c42~3',
				'board_university_1~Board / University'=>'c43~2',
				'year_1~Year'=>'c44~1',
				'percentage_of_marks_1~% of Marks'=>'c45~2',
				'special_subjects_1~Optional Subjects'=>'c46~2',

				'course_2~Course'=>'c51~2',
				'name_of_institute_2~College / Institute'=>'c52~3',
				'board_university_2~Board / University'=>'c53~2',
				'year_2~Year'=>'c54~1',
				'percentage_of_marks_2~% of Marks'=>'c55~2',
				'special_subjects_2~Optional Subjects'=>'c56~2',

				'course_3~Course'=>'c61~2',
				'name_of_institute_3~College / Institute'=>'c62~3',
				'board_university_3~Board / University'=>'c63~2',
				'year_3~Year'=>'c64~1',
				'percentage_of_marks_3~% of Marks'=>'c65~2',
				'special_subjects_3~Optional Subjects'=>'c66~2',

				'course_4~Course'=>'c71~2',
				'name_of_institute_4~College / Institute'=>'c72~3',
				'board_university_4~Board / University'=>'c73~2',
				'year_4~Year'=>'c74~1',
				'percentage_of_marks_4~% of Marks'=>'c75~2',
				'special_subjects_4~Optional Subjects'=>'c76~2',

				'course_5~Course'=>'c81~2',
				'name_of_institute_5~College / Institute'=>'c82~3',
				'board_university_5~Board / University'=>'c83~2',
				'year_5~Year'=>'c84~1',
				'percentage_of_marks_5~% of Marks'=>'c85~2',
				'special_subjects_5~Optional Subjects'=>'c86~2',

				'course_6~Course'=>'c91~2',
				'name_of_institute_6~College / Institute'=>'c92~3',
				'board_university_6~Board / University'=>'c93~2',
				'year_6~Year'=>'c94~1',
				'percentage_of_marks_6~% of Marks'=>'c95~2',
				'special_subjects_6~Optional Subjects'=>'c96~2',

				'course_7~Course'=>'b1~2',
				'name_of_institute_7~College / Institute'=>'b2~3',
				'board_university_7~Board / University'=>'b3~2',
				'year_7~Year'=>'b4~1',
				'percentage_of_marks_7~% of Marks'=>'b5~2',
				'special_subjects_7~Optional Subjects'=>'b6~2',

				'course_8~Course'=>'b11~2',
				'name_of_institute_8~College / Institute'=>'b12~3',
				'board_university_8~Board / University'=>'b13~2',
				'year_8~Year'=>'b14~1',
				'percentage_of_marks_8~% of Marks'=>'b15~2',
				'special_subjects_8~Optional Subjects'=>'b16~2',

			]);

		$form->setModel($model_applicant);
		$form->addSubmit('Submit')->addClass('btn btn-primary');
		if($form->isSubmitted()){

			$form->model->save();

			$form->js()->univ()->redirect($this->app->url(null,['step'=>2,'course'=>$this->course]))->execute();
		}

	}

	function collegeSelectionForm(){
		
		$applicant = $this->add('xavoc\formwala\Model_Applicant');
		if(!$applicant->loadLoggedIn()){
			$this->add('View')->addClass('alert alert-warning')->set('Applicant is not logged in');
			return;
		}

		$asso = $this->add('xavoc\formwala\Model_CollegeCourseAssociation');
		$asso->addCondition('course_id',$this->course);

		$associated_college = $asso->_dsql()->del('fields')->field('college_id')->getAll();
		$associated_college = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($associated_college)),false);

		$clg = $this->add('xavoc\formwala\Model_College');
		if(is_array($associated_college) && count($associated_college)){
			$clg->addCondition('id','in',$associated_college);
		}

		$form = $this->add('Form');
		$form->add('xepan\base\Controller_FLC')
			->makePanelsCoppalsible(true)
			->showLables(true)
			->addContentSpot()
			->layout([
				'college_1~First College'=>'College Selection~c1~4',
				'college_2~Second College'=>'c2~4',
				'college_3~Third College'=>'c3~4'
			]);

		for ($i=1; $i < 4; $i++) {
			$field = $form->addField('xepan\base\DropDown','college_'.$i);
			$field->setModel($clg);
			$field->validate('required');
		}

		$form->addSubmit('Submit')->addClass('btn btn-primary');
		if($form->isSubmitted()){

			for ($i=1; $i < 4; $i++) {
				$asso = $this->add('xavoc\formwala\Model_ApplicantCourseCollegeAssociation');
				$asso['college_id'] = $form['college_'.$i];
				$asso['applicant_id'] = $applicant->id;
				$asso['course_id'] = $this->course;
				$asso->save();
			}

			$form->js()->univ()->redirect($this->app->url(null,['step'=>3,'course'=>$this->course]))->execute();
		}		

	}

	function finalStep(){
		$this->add('View')->set('Thank you')->addClass('alert alert-success');

	}

}