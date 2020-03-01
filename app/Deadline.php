<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deadline extends Model
{
    protected $table = 'deadlines';
    public $primaryKey = 'id';
    public $timestamps = true;

}
