<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKontrakModel extends Model
{
    use HasFactory;
    //table name
    protected $table = 'ifg_master_tipe_contract';
    //primary key
    protected $primaryKey = 'id';
    //set auto incrementing for PK
    public $incrementing = true;
    
}
