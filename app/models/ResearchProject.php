<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Vinelab\NeoEloquent\Eloquent\SoftDeletingTrait;

class ResearchProject extends NeoEloquent {

    use SoftDeletingTrait;

    protected $label = ['ResearchProejct'];

    protected $fillable = [
        'name_en',
        'name_th',
        'executive_summary',
        'area_operation',
        'area_context',
        'objectives',
        'procedures',
        'result_area',
        'result_researcher',
        'result_student',
        'acknowledgement'];

    public function researchers(){
        return $this->belongsToMany("Researcher","WORKINGON");
    }

    public function photos(){
        return $this->hasMany('Photo','PHOTO');
    }


}
