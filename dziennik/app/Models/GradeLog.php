<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeLog extends Model
{
    protected $fillable = [
        'grade_id',
        'changed_by',
        'old_grade',
        'new_grade',
        'comment',
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
