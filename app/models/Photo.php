<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Vinelab\NeoEloquent\Eloquent\SoftDeletingTrait;

class Photo extends NeoEloquent  {

	use  SoftDeletingTrait;

    protected $label = ['Photo'];

    protected $fillable = ['filetype', 'filename','base64','url'];

    public function photoable(){
        return $this->morphTo();
    }
}
