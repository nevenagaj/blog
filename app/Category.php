<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories'; //teling laravel to use categories table with this model

    public function posts()
    {
        return $this->hasMany('App\Post');
    }
}
