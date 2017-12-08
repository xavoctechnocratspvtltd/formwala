<?php

namespace xavoc\formwala;

class Tool_Login extends \xepan\cms\View_Tool{
	public $options = [
			'account_page'=>'step1'
		];

	function init(){
		parent::init();
		
		if($this->owner instanceof \AbstractController) return;

		$is_otp_send = $this->app->stickyGET('otp_send');

		if(!$is_otp_send){
			$form = $this->add('Form');
			$form->addField('Number','mobile_no');
			$form->addSubmit('Send OTP');
			if($form->isSubmitted()){
				$this->js()->reload(['otp_send'=>true])->execute();
			}
		}else{
			$form = $this->add('Form');
			$form->addField('Number','OTP');
			$form->addSubmit('Login');
			if($form->isSubmitted()){
				$this->app->stickyForget('otp_send');
				$this->app->redirect($this->app->url($this->options['account_page']))->execute();
			}
		}
	}
}