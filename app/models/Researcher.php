<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Vinelab\NeoEloquent\Eloquent\SoftDeletingTrait;

class Researcher extends NeoEloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

    protected  $label = ['Researcher'];

    protected $fillable = ['title','firstname','lastname'];

    public function getName(){
        return "$this->title $this->firstname $this->lastname";
    }

    public function getAuthIdentifier()
    {
        return $this->email;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function faculty(){
        return $this->belongsTo('Faculty','HAS');
    }

    public function profileImage(){
        return $this->hasOne('Photo','PHOTO');
    }

}
