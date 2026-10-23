<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultSubject extends Model
{
    protected $fillable = [
        'student_result_id',
        'subject',
        'marks_obtained',
        'max_marks'
    ];

    public function studentResult(): BelongsTo{
        return $this->belongsTo(StudentResult::class, 'student_result_id');
    } 
}
