<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mSchool extends Model
{
  use HasFactory, SoftDeletes;

  protected $table = 'school';
  protected $primaryKey = 'id_school';
  protected $dates = ['deleted_at'];
  protected $fillable = [
    'id_user',
    'sch_name',
    'sch_city',
    'sch_address',
    'created_at',
    'updated_at',
    'deleted_at',
  ];

  public function getAdmin() {
    return User::find($this->id_user);
  }
}