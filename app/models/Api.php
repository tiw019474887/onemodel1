<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Vinelab\NeoEloquent\Eloquent\SoftDeletingTrait;

class Api extends NeoEloquent  {

	use  SoftDeletingTrait;

    protected $label = ['Api'];

    protected $fillable = ['key', 'status'];

}
