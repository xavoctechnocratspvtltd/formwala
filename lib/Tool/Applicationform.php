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
		$tab = $this->add('Tabs');
		$this->r_tab = $r_tab = $tab->addTab('Registration');
		$this->t_tab = $t_tab = $tab->addTab('Write a Testimonial');

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

		$form = $this->t_tab->add('Form');
		$form->addField('text','review')->validate('required');
		$form->addSubmit('Submit New Review')->addClass('btn btn-primary');
		$model_applicant = $this->r_tab->add('xavoc\formwala\Model_Applicant');
		$model_applicant->loadLoggedIn();

		$this->t_tab->add('View')->setHtml('<h3>Your Review History</h3>')->addClass('heading');
		$grid = $this->t_tab->add('Grid');

		if($form->isSubmitted()){
			
			$image_url = $model_applicant['image'];
			$img_path = explode($this->app->current_website_name, $image_url)[1];
			
			$this->app->skipDefaultTemplateJsonUpdate = true;
			$cat = $this->add('xepan\cms\Model_CarouselCategory');
			$cat->addCondition('name','Testimonial');
			$cat->tryLoadAny();
			$cat->save();

			$img = $this->add('xepan\cms\Model_CarouselImage');
			$img['carousel_category_id'] = $cat->id;
			$img['status'] = "Hidden";
			$img['title'] = $model_applicant['first_name']." ".$model_applicant['last_name'];
			$img['text_to_display'] = $form['review'];
			$img['slide_type'] = "Image";
			$img['created_by_id'] = $model_applicant['id'];
			$img['file_id'] = $img_path;
			$img->save();

			$form->js(null,[$form->js()->reload(),$grid->js()->reload()])->univ()->successMessage('Your Review has been submitted successfully')->execute();
		}

		$review_model = $this->add('xepan\cms\Model_CarouselImage')->addCondition('created_by_id',$model_applicant->id);
		$review_model->getElement('created_at')->caption('Date');
		$review_model->setOrder('created_at','desc');
		$grid->setModel($review_model,['created_at','text_to_display','status']);
		$grid->addPaginator($ipp=5);
	}

	function applicantForm(){
		$this->r_tab->add('View')->setHtml('<div class="section-title-wrapper"><div class="section-title"><h2>Registration form</h2><ul><li>Please fill in the form & (*) mark fields are mandatory</li></ul></div></div>');

		$model_applicant = $this->r_tab->add('xavoc\formwala\Model_Applicant');
		if(!$model_applicant->loadLoggedIn()){
			$this->r_tab->add('View')->addClass('alert alert-warning')->set('Applicant is not logged in');
			return;
		}

		$field_to_remove = ['created_by_id','assign_to_id','post','website','source','remark','score','assign_at','freelancer_type','related_with','related_id','local_country_id','local_state_id','local_city','local_address','local_pin_code'];
		foreach ($field_to_remove as $field) {
			$model_applicant->getElement($field)->destroy();
		}
		$model_applicant->getElement('created_at')->system(true);
		$model_applicant->getElement('updated_at')->system(true);
		$model_applicant->getElement('organization')->system(true);

		$form = $this->r_tab->add('Form');
		$form->add('xepan\base\Controller_FLC')
			->makePanelsCoppalsible(true)
			->showLables(true)
			->addContentSpot()
			->layout([
				'first_name~First Name &nbsp;<i class="fa fa-asterisk formwala-mandatory"></i>'=>'Personal Information~c1~4',
				'middle_name'=>'c2~4',
				'last_name~Last Name &nbsp;<i class="fa fa-asterisk formwala-mandatory"></i>'=>'c3~4',
				'image_id~Profile Picture &nbsp;<i class="fa fa-asterisk formwala-mandatory"></i>'=>'c4~4',
				'mobile_no'=>'c5~4',
				'dob~DOB &nbsp;<i class="fa fa-asterisk formwala-mandatory"></i>'=>'c5~4',
				'blood_group'=>'c5~4',
				'email_id~Email Id &nbsp;<i class="fa fa-asterisk formwala-mandatory"></i>'=>'c6~4',
				'gender~Gender &nbsp;<i class="fa fa-asterisk formwala-mandatory"></i>'=>'c6~4',
				'marital_status~Marital Status &nbsp;<i class="fa fa-asterisk formwala-mandatory"></i>'=>'c6~4',
				'aadhar_no'=>'c5~4',
				
				'country_id~Country &nbsp;<i class="fa fa-asterisk formwala-mandatory"></i>'=>'Permanent Address~c11~4',
				'state_id~State &nbsp;<i class="fa fa-asterisk formwala-mandatory"></i>'=>'c12~4',
				'city~City &nbsp;<i class="fa fa-asterisk formwala-mandatory"></i>'=>'c13~4',
				'address~Address &nbsp;<i class="fa fa-asterisk formwala-mandatory"></i>'=>'c14~8',
				'pin_code~Pin Code &nbsp;<i class="fa fa-asterisk formwala-mandatory"></i>'=>'c15~4',

				// 'local_country_id~Country'=>'Local Address~c21~4',
				// 'local_state_id~State'=>'c22~4',
				// 'local_city~City'=>'c23~4',
				// 'local_address~Address'=>'c24~4',
				// 'local_pin_code~Pin Code'=>'c25~4',
				
				'father_name~Father Name &nbsp;<i class="fa fa-asterisk formwala-mandatory"></i>'=>'Guardian Detail~c31~4',
				'father_contact_no~Father Contact No &nbsp;<i class="fa fa-asterisk formwala-mandatory"></i>'=>'c32~4',
				'occupation_of_father'=>'c33~4',
				'mother_name~Mother Name &nbsp;<i class="fa fa-asterisk formwala-mandatory"></i>'=>'c34~4',
				'mother_contact_no'=>'c35~4',
				'occupation_of_mother'=>'c36~4',

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

				'course_4~Course'=>'c71~2',
				'name_of_institute_4~College / Institute'=>'c72~4',
				'board_university_4~Board / University'=>'c73~3',
				'year_4~Year'=>'c74~1',
				'percentage_of_marks_4~% of Marks'=>'c75~2',
			]);

		$form->setModel($model_applicant);

		if($model_applicant['first_name'] == "Guest"){
			$form->getElement('first_name')->set("");
		}

		$form->getElement('mobile_no')->setAttr('disabled');
		$form->getElement('course_1')->set('10th')->setAttr('disabled');
		$form->getElement('course_2')->set('12th')->setAttr('disabled');
		$form->getElement('course_3')->set('Graduation')->setAttr('disabled');
		$form->getElement('course_4')->set('Other')->setAttr('disabled');

		$country_field = $form->getElement('country_id');
		$state_field = $form->getElement('state_id');
		$country_id = $this->app->stickyGET('country_id');

		$country_field->js('change',$state_field->js()->reload(null,null,[$this->app->url(null,['cut_object'=>$state_field->name]),'country_id'=>$country_field->js()->val()]));
		if($country_id){
			$state_field->getModel()->addCondition('country_id',$country_id);
		}

		$form->addSubmit('Submit')->addClass('btn btn-primary btn-block');
		if($form->isSubmitted()){
			$mandatory_field = ['first_name','last_name','image_id','email_id','dob','gender','marital_status','country_id','state_id','city','address','pin_code','father_name','father_contact_no','mother_name'];

			foreach ($mandatory_field as $key => $field) {
				if(!trim($form[$field])) $form->error($field, $field.' must not be empty');

				if( !filter_var($form['email_id'], FILTER_VALIDATE_EMAIL)){
		            return $form->error('email_id','Must be a valid email address');
		        }
			}
			
			$form['course_1'] = '10th';
			$form['course_2'] = '12th';
			$form['course_3'] = 'Graduation';
			$form['course_4'] = 'Other';
			$form->save();

			$form->js()->univ()->redirect($this->app->url(null,['step'=>2,'course'=>$this->course]))->execute();
		}

	}

	function collegeSelectionForm(){
		
		$this->r_tab->add('View')->setHtml('<div class="section-title-wrapper"><div class="section-title"><h2>Select College </h2></div></div>');

		$applicant = $this->r_tab->add('xavoc\formwala\Model_Applicant');
		if(!$applicant->loadLoggedIn()){
			$this->r_tab->add('View')->addClass('alert alert-warning')->set('Applicant is not logged in');
			return;
		}
		if(!$this->course){
			$this->r_tab->add('View')->addClass('alert alert-warning')->set('course not selected');
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
		$clg->setOrder('first_name','asc');

		$form = $this->r_tab->add('Form');
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

				// send email to College List
				$config_m = $this->add('xepan\base\Model_ConfigJsonModel',
				[
					'fields'=>[
								'advertisement_slide_speed'=>'Line',
								'testimonial_slide_speed'=>'Line',
								'email_subject'=>'Line',
								'email_body'=>'xepan\base\RichText',
								'send_email'=>'checkbox'
							],
						'config_key'=>'FORMWALA_CONFIGURATION',
						'application'=>'formwala'
				]);

				$config_m->tryLoadAny();
				
				if($config_m['send_email'] != "1"){
					continue;
				} 

				$clg = $this->add('xavoc\formwala\Model_College');
				$clg->addCondition('id',$asso['college_id']);
				$clg->tryLoadAny();
				if(!$clg->loaded()) {
					continue;
				}

				if(!$clg['emails_str']){
					continue;
				}

				$email_setting = $this->add('xepan\communication\Model_Communication_EmailSetting');
				$email_setting->tryLoadAny();
				if(!$email_setting->loaded()){
					continue;
				}

				$to_emails = explode("<br/>", trim($clg['emails_str']));

				$temp = $applicant->data;
				$data = array_merge($temp,$asso->data);

				$email_body = $config_m['email_body'];
				$layout = $this->add('GiTemplate');
				$layout->loadTemplateFromString($email_body);
				$view = $this->add('View',null,null,$layout);
				$view->template->set($data);
				$html = $view->getHTML();
				
				$communication = $this->add('xepan\communication\Model_Communication_Abstract_Email');
				$communication->addCondition('communication_type','Email');

				$communication->getElement('status')->defaultValue('Draft');
				$communication['direction'] = 'Out';
				$communication->setfrom($email_setting['from_email'],$email_setting['from_name']);
				
				foreach ($to_emails as $key => $value) {
					$communication->addTo(trim($value));
				}

				$communication->setSubject($config_m['email_subject']);
				$communication->setBody($html);
				$communication->send($email_setting);
			}
			
			$form->js()->univ()->redirect($this->app->url(null,['step'=>3,'course'=>$this->course]))->execute();
		}		

	}

	function finalStep(){
		$v = $this->r_tab->add('View')->setstyle('min-height','300px');
		$v->add('View')->setHtml('<h4 class="text-center">Form has been submitted successfully. we will call back to you with in 2 days. <br/>Thank You Very Much</h4>')->addClass('alert alert-success');
		
	}

	function linkDisplay(){
		$this->add('View')->addClass('text-center heading')->setElement('h2')->set("Select Your Link");
		$this->add('xavoc\formwala\Tool_Course',['options'=>['type'=>'link','redirect_to_original_link'=>1]]);
	}


}