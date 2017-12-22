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
			$this->add('View')->addClass('alert alert-warning')->set('Please Select Course first to proceed');
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

		// $pb = $this->add('xepan\epanservices\View_ProgressBar',['active_step'=>$active_step]);

		switch ($active_step) {
			case '1':
				$this->applicantForm();
				break;
			case '2':
				if($model['is_link']){
					$this->linkDisplay();
				}else
					$this->collegeSelectionForm();
				break;
			case '3':
				$this->finalStep();
				break;
		}
	}

	function applicantForm(){
		$this->add('View')->setHtml('<div class="section-title-wrapper"><div class="section-title"><h2>Registration form</h2><ul><li>Please fill in the form & All fields are mandatory</li></ul></div></div>');

		$model_applicant = $this->add('xavoc\formwala\Model_Applicant');
		if(!$model_applicant->loadLoggedIn()){
			$this->add('View')->addClass('alert alert-warning')->set('Applicant is not logged in');
			return;
		}

		$field_to_remove = ['created_by_id','assign_to_id','post','website','source','remark','score','assign_at','freelancer_type','related_with','related_id','local_country_id','local_state_id','local_city','local_address','local_pin_code'];
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
				'dob'=>'c5~4',
				'blood_group'=>'c5~4',
				'email_id'=>'c6~4',
				'gender'=>'c6~4',
				'marital_status'=>'c6~4',
				
				'country_id~Country'=>'Permanent Address~c11~4',
				'state_id~State'=>'c12~4',
				'city'=>'c13~4',
				'address'=>'c14~8',
				'pin_code'=>'c15~4',

				// 'local_country_id~Country'=>'Local Address~c21~4',
				// 'local_state_id~State'=>'c22~4',
				// 'local_city~City'=>'c23~4',
				// 'local_address~Address'=>'c24~4',
				// 'local_pin_code~Pin Code'=>'c25~4',
				
				'father_name'=>'Guardian Detail~c31~3',
				'occupation_of_father'=>'c33~3',
				'mother_name'=>'c32~3',
				'occupation_of_mother'=>'c34~3',

				'course_1~Course'=>'Educational Details~c41~2',
				'name_of_institute_1~School / Institute'=>'c42~4',
				'board_university_1~Board / University'=>'c43~3',
				'year_1~Year'=>'c44~1',
				'percentage_of_marks_1~% of Marks'=>'c45~2',

				'course_2~Course'=>'c51~2',
				'name_of_institute_2~College / Institute'=>'c52~4',
				'board_university_2~Board / University'=>'c53~3',
				'year_2~Year'=>'c54~1',
				'percentage_of_marks_2~% of Marks'=>'c55~2',

				'course_3~Course'=>'c61~2',
				'name_of_institute_3~College / Institute'=>'c62~4',
				'board_university_3~Board / University'=>'c63~3',
				'year_3~Year'=>'c64~1',
				'percentage_of_marks_3~% of Marks'=>'c65~2',
			]);

		$form->setModel($model_applicant);

		$form->getElement('course_1')->set('10th')->setAttr('disabled');
		$form->getElement('course_2')->set('12th')->setAttr('disabled');
		$form->getElement('course_3')->set('Graduation')->setAttr('disabled');

		$country_field = $form->getElement('country_id');
		$state_field = $form->getElement('state_id');
		$country_id = $this->app->stickyGET('country_id');

		$country_field->js('change',$state_field->js()->reload(null,null,[$this->app->url(null,['cut_object'=>$state_field->name]),'country_id'=>$country_field->js()->val()]));
		if($country_id){
			$state_field->getModel()->addCondition('country_id',$country_id);
		}

		$form->addSubmit('Submit')->addClass('btn btn-primary btn-block');
		if($form->isSubmitted()){
			$mandatory_field = ['first_name','last_name','image_id','mobile_no','email_id','dob','gender','marital_status','blood_group','country_id','state_id','city','address','pin_code','father_name','mother_name','occupation_of_father','occupation_of_mother','name_of_institute_1','board_university_1','year_1','percentage_of_marks_1','name_of_institute_2','board_university_2','year_2','percentage_of_marks_2','name_of_institute_3','board_university_3','year_3','percentage_of_marks_3'];

			foreach ($mandatory_field as $key => $field) {
				if(!trim($form[$field])) $form->error($field, $field.' must not be empty');

				if( !filter_var($form['email_id'], FILTER_VALIDATE_EMAIL)){
		            return $form->error('email_id','Must be a valid email address');
		        }

		        // if($form[''])
			}


			$form['course_1'] = '10th';
			$form['course_2'] = '12th';
			$form['course_3'] = 'Graduation';

			$form->model->save();
			$form->js()->univ()->redirect($this->app->url(null,['step'=>2,'course'=>$this->course]))->execute();
		}

	}

	function collegeSelectionForm(){
		
		$this->add('View')->setHtml('<div class="section-title-wrapper"><div class="section-title"><h2>Select College </h2></div></div>');

		$applicant = $this->add('xavoc\formwala\Model_Applicant');
		if(!$applicant->loadLoggedIn()){
			$this->add('View')->addClass('alert alert-warning')->set('Applicant is not logged in');
			return;
		}
		if(!$this->course){
			$this->add('View')->addClass('alert alert-warning')->set('course not selected');
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
			$field->setEmptyText('Please Select College');
			$field->validate('required');
		}

		$form->addSubmit('Submit')->addClass('btn btn-primary btn-block');
		if($form->isSubmitted()){

			if($form['college_1'] == $form['college_2'])
				$form->error('college_2','college_1 and college_2 must not be same, select another college');
			if($form['college_1'] == $form['college_3'])
				$form->error('college_3','college_1 and college_3 must not be same, select another college');	
			if($form['college_2'] == $form['college_3'])
				$form->error('college_3','college_2 and college_3 must not be same, select another college');
			
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

	function linkDisplay(){
		$this->add('View')->addClass('text-center heading')->setElement('h2')->set("Select Your Link");
		$this->add('xavoc\formwala\Tool_Course',['options'=>['type'=>'link','redirect_to_original_link'=>1]]);
	}


}