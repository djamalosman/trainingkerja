<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MtrainingCourseModel extends Model
{
    use HasFactory;
    //table name
    protected $table = 'm_training_course';
    //primary key
    protected $primaryKey = 'id';
    //set auto incrementing for PK
    public $incrementing = true;
}
