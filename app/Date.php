<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date'];
}
