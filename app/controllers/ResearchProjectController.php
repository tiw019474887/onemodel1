<?php

class ResearchProjectController extends BaseController {

    public function getIndex() {

        return View::make('researchprojects.index');
    }

    public function getView($id){
        return View::make('researchprojects.view')->with('id',$id);
    }

}
