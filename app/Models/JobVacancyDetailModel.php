<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancyDetailModel extends Model
{
    use HasFactory;
    //table name
    protected $table = 'job_vacancy_detail';

    protected $primaryKey = 'id';
    //set auto incrementing for PK
    public $incrementing = true;

    protected $fillable = ['id_job_m_vacancy', 'vacancy_name','location','status_vacancy','posted_date','close_date','vacancy_level','vacancy_description','vacancy_description_en','file','insert_by', 'updated_by','updated_by_ip','salary','status'];
}
