<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class mAssistance extends Model
{
  use HasFactory, SoftDeletes;

  protected $table = 'assistance';
  protected $primaryKey = 'id_assistance';
  protected $dates = [
    'ast_proposed_date',
    'deleted_at',
  ];
  protected $fillable = [
    'id_school',
    'id_user',
    'ast_description',
    'ast_proposed_datetime',
    'ast_student_level',
    'ast_no_of_student',
    'ast_resource_type',
    'ast_no_of_resource',
    'ast_type',
    'ast_status',
  ];

  public function getSchoolAttribute()
  {
    return mSchool::find($this->id_school);
  }

  public function getAdminAttribute()
  {
    return User::find($this->id_user);
  }
}
