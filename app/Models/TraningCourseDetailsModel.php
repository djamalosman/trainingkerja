<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TraningCourseDetailsModel extends Model
{
    use HasFactory;
     //table name
     protected $table = 'training_course_detail';

     
     protected $fillable = ['id_m_traning_course', 'id_m_sertifikasi','traning_name','training_duration',
     'requirements','registration_schedule','startdate','enddate','registrationfee','training_material','closing_schedule',
     'facility','typeonlineoffile','location','file','status',
     'link_pendaftaran','insert_by', 'updated_by','updated_by_ip']; 

}
