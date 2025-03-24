<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'tblcomment_ia';
    protected $primaryKey = 'transid';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    
    protected $fillable = [
        'transid',
        'school_code',
        'acyear',
        'term',
        'student_no',
        'class_code',
        'ct_remarks',
        'source',
        'import',
        'export',
        'deleted',
        'createuser',
        'createdate',
        'modifyuser',
        'modifydate'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_no', 'student_no');
    }
}