<?php

namespace xavoc\formwala;

class Tool_Applicationform extends \xepan\cms\View_Tool{
	public $options = [

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
		$form = $this->add('Form');
		$form->setModel($model_applicant,['first_name','last_name']);
		$form->addSubmit('Next');
		if($form->isSubmitted()){	
			$form->js()->univ()->redirect($this->app->url(null,['step'=>2,'course'=>$this->course]))->execute();
		}

	}

	function collegeSelectionForm(){
		$this->add('View')->set('College Selection form')->addClass('alert alert-info');
		
		$asso = $this->add('xavoc\formwala\Model_CollegeCourseAssociation');
		$asso->addCondition('course_id',$this->course);

		$associated_college = $asso->_dsql()->del('fields')->field('college_id')->getAll();
		$associated_college = iterator_to_array(new \RecursiveIteratorIterator(new \RecursiveArrayIterator($associated_college)),false);

		$clg = $this->add('xavoc\formwala\Model_College');
		if(is_array($associated_college) && count($associated_college)){
			$clg->addCondition('id','in',$associated_college);
		}

		$form = $this->add('Form');
		for ($i=1; $i < 3; $i++) { 
			$form->addField('xepan\base\DropDown','college_'.$i)
					->setModel($clg);
		}

		$form->addSubmit('Next');
		if($form->isSubmitted()){
			$form->js()->univ()->redirect($this->app->url(null,['step'=>3,'course'=>$this->course]))->execute();
		}		

	}

	function finalStep(){
		$this->add('View')->set('Thank you')->addClass('alert alert-success');

	}

}