<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Vinelab\NeoEloquent\Eloquent\SoftDeletingTrait;

class User extends NeoEloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, SoftDeletingTrait;

    protected  $label = ['User'];

    protected $fillable = ['email','title','firstname','lastname'];


    public function getName(){
        return "$this->title $this->firstname $this->lastname";
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function profileImage(){
        return $this->hasOne('Photo','PROFILEPHOTO');
    }

    public function news(){
        return $this->hasMany('News',"CREATE");
    }

    public static  function isUniqueEmail($email){
        $user = User::where('email','=',$email)->first();
        if ($user){
            return false;
        }
        return true;
    }

}
