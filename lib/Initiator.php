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

        $m = $this->app->top_menu->addMenu('All Samaj');
        $m->addItem(['All Samaj','icon'=>' fa fa-file-image-o'],'xavoc_allsamaj_samaj');
        $m->addItem(['Slider','icon'=>' fa fa-file-image-o'],'xavoc_allsamaj_slider');
        // $m->addItem(['News','icon'=>' fa fa-file-image-o'],'xavoc_allsamaj_news');
        // $m->addItem(['Committee','icon'=>' fa fa-file-image-o'],'xavoc_allsamaj_committee');
        // $m->addItem(['Member','icon'=>' fa fa-file-image-o'],'xavoc_allsamaj_member');
        // $m->addItem(['Committee Member','icon'=>' fa fa-file-image-o'],'xavoc_allsamaj_committeemember');
        $m->addItem(['Location Management','icon'=>' fa fa-file-image-o'],'xavoc_allsamaj_location');
        
    	return $this;
    }

    function setup_frontend(){
        $this->routePages('xavoc_formwala');
        $this->addLocation(array('template'=>'templates','js'=>'templates/js','css'=>['templates/css','templates/js']))
        ->setBaseURL('./shared/apps/xavoc/formwala/');

        $this->app->exportFrontEndTool('xavoc\formwala\Tool_Student','FormWala');
        $this->app->exportFrontEndTool('xavoc\formwala\Tool_Course','FormWala');
        

    	return $this;
    }
}