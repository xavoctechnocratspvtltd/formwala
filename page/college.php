<?php

namespace xavoc\formwala;

class page_college extends \xepan\base\Page{
	public $title = "College Management";

	function init(){
		parent::init();
		
		$crud = $this->add('xepan\hr\CRUD');
		$model = $this->add('xavoc\formwala\Model_College');
		if($crud->isEditing()){
			$form = $crud->form;
			$form->add('xepan\base\Controller_FLC')
				->addContentSpot()
				->makePanelsCoppalsible(true)
				->layout([
					'first_name~Name'=>'College Detail~c1~12',
					'address'=>'c2~4',
					'country_id'=>'c3~4',
					'state_id'=>'c3~4',
					'city'=>'c3~4',
					'pin_code'=>'c4~4',
					'email_id'=>'c5~12',
					'contact_no'=>'c6~12',
				])
				;
		}

		if($form = $crud->form){
			$form->addField('email_id',null,'Email Ids')->setFieldHint("(,) comma seperated multiple value");
			$form->addField('contact_no')->setFieldHint("(,) comma seperated multiple value");
		}
		$crud->addHook('formSubmit',function($c,$form_obj){

			$contact_model = $form_obj->model;
			$contact_model->set($form_obj->getAllFields());
			$contact_model->save();

			$form = $form_obj;
				try{

					if($form['email_id']){
						$email = $this->add('xepan\base\Model_Contact_Email');
						$email->addCondition('contact_id',$form->model->id);
						$email->deleteAll();

						$emails = explode(",", $form['email_id']);
						foreach ($emails as $key => $value) {
							$email = $this->add('xepan\base\Model_Contact_Email');
							$email->addCondition('contact_id',$form->model->id);
							$email->addCondition('value',trim($value));
							$email->tryLoadAny();
							
							$email['head'] = "Official";
							$email->saveAndUnload();
						}
					}

					if($form['contact_no']){
						$contacts = explode(",", $form['contact_no']);
						$email = $this->add('xepan\base\Model_Contact_Phone');
						$email->addCondition('contact_id',$form->model->id);
						$email->deleteAll();
						
						foreach ($contacts as $key => $value) {
							$email = $this->add('xepan\base\Model_Contact_Phone');
							$email->addCondition('value',trim($value));
							$email->addCondition('contact_id',$form->model->id);
							$email->tryLoadAny();
							
							$email['head'] = "Official";
							$email->saveAndUnload();
						}
					}

				// $this->app->db->commit();
			}catch(\Exception $e){
				$contact_model->delete();
				$this->api->db->rollback();
				throw new \Exception($e->getMessage());
				
			}


			
			return true; // do not proceed with default crud form submit behaviour
		});

		$crud->setModel($model,['first_name','address','city','state_id','country_id','pin_code','contacts_str','emails_str']);
		$crud->grid->addPaginator($ipp=25);
		$crud->grid->removeAttachment();

		$state_field = $crud->form->getElement('state_id');
		$state_field->getModel()->addCondition('status','Active');
		if($country_id = $this->app->stickyGET('country_id')){
			$state_field->getModel()->addCondition('country_id',$country_id);
		}		
		$country_field = $crud->form->getElement('country_id');
		$country_field->getModel()->addCondition('status','Active');
		$country_field->js('change',$state_field->js()->reload(null,null,[$this->app->url(null,['cut_object'=>$state_field->name]),'country_id'=>$country_field->js()->val()]));

		if($crud->isEditing('add') OR $crud->isEditing('edit')){
			$crud->form->getElement('email_id')->set(str_replace("<br/>", ",", $crud->model['emails_str']));
			$crud->form->getElement('contact_no')->set($crud->model['contacts_comma_seperated']);
		}
	}	
}