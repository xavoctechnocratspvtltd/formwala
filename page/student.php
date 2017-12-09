<?php

namespace xavoc\formwala;

class page_student extends \xepan\base\Page{
		
		function init(){
			parent::init();

			$crud = $this->add('xepan\hr\CRUD');
			if($crud->isEditing()){
				$form = $crud->form;
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

						'user_id'=>'Extra Info~b21~3',
						'created_at'=>'b22~3',
						'updated_at'=>'b23~2'
					]);
			}


			$model = $this->add('xavoc\formwala\Model_Applicant');
			$model->setOrder('id','desc');

			$all_fields = $model->getActualFields();
			$all_fields = array_combine($all_fields, $all_fields);		

			$field_to_remove = ['created_by_id','organization','assign_to_id','post','website','source','remark','score','assign_at','freelancer_type','related_with','related_id'];
			foreach ($field_to_remove as $field) {
				unset($all_fields[$field]);
			}
			
			$crud->setModel($model,$all_fields,['first_name','last_name','mobile_no','email_id','created_at']);
			$crud->grid->removeAttachment();

			$crud->grid->addQuickSearch(['first_name','lst_name','mobile_no','email_id']);
			$crud->grid->addPaginator($ipp=50);

		}	
}