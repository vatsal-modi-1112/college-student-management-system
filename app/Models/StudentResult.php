<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentResult extends Model
{
    protected $fillable = [
        'student_id',
        'semester',
        'academic_year',
        'result_date'
    ];

    protected $casts = [
        'result_date' => 'date',
    ]; 

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function subjects(){
        return $this->hasMany(ResultSubject::class, 'student_result_id');
    }
}
