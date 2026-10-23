<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable=[
        'name',
        'email',
        'password',
        'course',
        'semester',
        'phone'
    ];

    public function studentResults(){
        return $this->hasMany(StudentResult::class, 'student_id');
    }
}
