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
        $m->addItem(['Link','icon'=>' fa fa-cog'],'xavoc_formwala_link');
        $m->addItem(['College','icon'=>' fa fa-cog'],'xavoc_formwala_college');
        $m->addItem(['Applicant','icon'=>' fa fa-cog'],'xavoc_formwala_student');
        
    	return $this;
    }

    function setup_pre_frontend(){
        $this->routePages('xavoc_formwala');
        $this->addLocation(array('template'=>'templates','js'=>'templates/js','css'=>['templates/css','templates/js']))
        ->setBaseURL('./shared/apps/xavoc/formwala/');

    }
    
    function setup_frontend(){
        $this->routePages('xavoc_formwala');
        $this->addLocation(array('template'=>'templates','js'=>'templates/js','css'=>['templates/css','templates/js']))
        ->setBaseURL('./shared/apps/xavoc/formwala/');

        $this->app->exportFrontEndTool('xavoc\formwala\Tool_Applicationform','FormWala');
        $this->app->exportFrontEndTool('xavoc\formwala\Tool_Course','FormWala');
        $this->app->exportFrontEndTool('xavoc\formwala\Tool_Login','FormWala');
        $this->app->exportFrontEndTool('xavoc\formwala\Tool_Carousel','FormWala');
        
    	return $this;
    }
}