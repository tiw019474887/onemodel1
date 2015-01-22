<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Vinelab\NeoEloquent\Eloquent\SoftDeletingTrait;

class Faculty extends NeoEloquent {

    use SoftDeletingTrait;

    protected $label = ['Faculty'];

    protected $fillable = ['name_en', 'name_th'];

}
