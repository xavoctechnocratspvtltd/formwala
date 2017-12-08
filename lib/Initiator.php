<?php

namespace xavoc\formwala;

class Initiator extends \Controller_Addon {
    public $addon_name = 'xavoc_formwala';

    function setup_admin(){

    	if($this->app->is_admin){
            $this->routePages('xavoc_formwala');
            $this->addLocation(array('template'=>'templates','js'=>'templates/js','css'=>['templates/css','templates/js']))
            ->setBaseURL('../shared/apps/xavoc/');
        }

        $m = $this->app->top_menu->addMenu('Formwala');
        $m->addItem(['Course','icon'=>' fa fa-cog'],'xavoc_formwala_course');
        $m->addItem(['College','icon'=>' fa fa-cog'],'xavoc_formwala_college');
        $m->addItem(['Student','icon'=>' fa fa-cog'],'xavoc_formwala_student');
        
    	return $this;
    }

    function setup_frontend(){
        $this->routePages('xavoc_formwala');
        $this->addLocation(array('template'=>'templates','js'=>'templates/js','css'=>['templates/css','templates/js']))
        ->setBaseURL('./shared/apps/xavoc/formwala/');

        $this->app->exportFrontEndTool('xavoc\formwala\Tool_Applicationform','FormWala');
        $this->app->exportFrontEndTool('xavoc\formwala\Tool_Course','FormWala');
        $this->app->exportFrontEndTool('xavoc\formwala\Tool_Login','FormWala');
        
        $this->app->addHook('login_panel_user_loggedin',function($app,$user){

            // $m = $this->add('xavoc\mlm\Model_Distributor');
            // $m->loadLoggedIn('Customer');
            // if($m->loaded()){
            //     $this->app->redirect($this->app->url('applicationform'));
            // }
        });

    	return $this;
    }
}