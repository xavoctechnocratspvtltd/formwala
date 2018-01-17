<?php

namespace xavoc\formwala;

class page_configuration extends \xepan\base\Page{
	public $title = "Configuration";

	function init(){
		parent::init();

		$config_m = $this->add('xepan\base\Model_ConfigJsonModel',
		[
			'fields'=>[
						'advertisement_slide_speed'=>'Line',
						'testimonial_slide_speed'=>'Line',
						'colleges_slide_speed'=>'Line',
						'email_subject'=>'Line',
						'email_body'=>'xepan\base\RichText'
					],
				'config_key'=>'FORMWALA_CONFIGURATION',
				'application'=>'formwala'
		]);
		$config_m->tryLoadAny();

		$m = $this->add('xavoc\formwala\Model_Applicant');
		$detail_hint = "";
		foreach ($m->getActualFields() as $key => $fields) {
			$detail_hint .= '{'.$fields.'},';
		}


		$form = $this->add('Form');
		$form->add('xepan\base\Controller_FLC')
			->showLables(true)
			->addContentSpot()
			->makePanelsCoppalsible(true)
			->layout([
				'advertisement_slide_speed'=>'Carousel Speed~c1~4~Speed in millisecond',
				'testimonial_slide_speed'=>'c2~4~Speed in millisecond',
				'colleges_slide_speed'=>'c3~4~Speed in millisecond',
				'email_subject'=>'Email Content send to college~c4~12',
				'email_body'=> 'c5~12'
			]);
		$form->add('View')->set($detail_hint);
		$form->setModel($config_m);
		$form->addSubmit('Save')->addClass('btn btn-primary');
		if($form->isSubmitted()){
			$form->save();
			$form->js(null,$form->js()->reload())->univ()->successMessage('update successfully')->execute();
		}

	}
}