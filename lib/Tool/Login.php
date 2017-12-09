<?php

namespace xavoc\formwala;

class Tool_Login extends \xepan\cms\View_Tool{
	public $options = [
			'account_page'=>''
		];

	function init(){
		parent::init();
		
		if($this->owner instanceof \AbstractController) return;

		$is_otp_send = $this->app->stickyGET('otp_send');
		$mobile_no = $this->app->stickyGET('uid');
		$course = $this->app->stickyGET('course');

		if(!$is_otp_send){
			$form = $this->add('Form');
			$form->addField('Number','mobile_no');
			$form->addSubmit('Send OTP');
			if($form->isSubmitted()){

				$otp = rand(1111,9999);
				// base user model entry 

				$user = $this->add('xepan\base\Model_User');
				$this->add('BasicAuth')
				->usePasswordEncryption('md5')
				->addEncryptionHook($user);
				
				$user->addCondition('username',$form['mobile_no']);
				$user->addCondition('scope','WebsiteUser');
				$user->tryLoadAny();
				$user['password'] = $otp;
				$user['type'] = 'User';
				$user['hash'] = $otp;
				$user['status'] = "Active";
				$user->save();

				$applicant = $this->add('xavoc\formwala\Model_Applicant');
				$applicant->addCondition('mobile_no',$form['mobile_no']);
				$applicant->addCondition('user_id',$user->id);
				$applicant->tryLoadAny();
				$applicant->save();

				$this->js(null,$form->js()->univ()->successMessage("OTP:".$otp))->reload(['otp_send'=>true,'uid'=>$form['mobile_no'],'course'=>$course])->execute();
			}				
		}else{
			if(!$mobile_no){
				$this->add('View')->set('Mobile No not defined')->addClass('alert alert-warning');
				return;
			}

			$form = $this->add('Form');
			// $form->addField('Number','mobile_no');
			$form->addField('Number','otp');
			$form->addSubmit('Login');
			$auth=$this->app->auth;

			if($form->isSubmitted()){

				// login user and redirect to apllication form
				if(!$credential = $this->app->auth->verifyCredentials($mobile_no,$form['otp'])){
					$form->displayError($form->getElement('otp'),'wrong credentials');
				}

				$user = $this->add('xepan\base\Model_User')->load($credential);
				if($user['status']=='Inactive')

				$form->displayError('otp','Please Activate Your Account First');
				$auth->login($mobile_no);

				$this->app->stickyForget('otp_send');
				$this->app->stickyForget('uid');

				$this->app->redirect($this->app->url($this->options['account_page'],['course'=>$course]))->execute();
			}
		}
	}
}