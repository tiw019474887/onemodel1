<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Vinelab\NeoEloquent\Eloquent\SoftDeletingTrait;

class News extends NeoEloquent  {

	use  SoftDeletingTrait;

    protected $label = ['News'];

    protected $fillable = ['header', 'content','is_pinned'];

    public function photos(){
        return $this->hasMany('Photo','PHOTO');
    }

    public function user(){
        return $this->belongsTo("User","CREATE");
    }

    public function getPhotos($skip=0){
        $news = $this;
        $photos = $news->photos()->take(8)->skip((int)$skip)->get();
        return $photos;
    }


}
