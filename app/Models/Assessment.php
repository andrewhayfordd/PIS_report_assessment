<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    protected $table = 'tblreport_assessment';
    protected $primaryKey = 'transid';
    public $timestamps = false;
    
    protected $fillable = [
        'school_code', 'acyear', 'term', 'student_no', 'mcode', 
        'result', 'deleted', 'createuser', 'createdate',
        'modifyuser', 'modifydate'
    ];
    
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_no', 'student_no');
    }
    
    public function item()
    {
        return $this->belongsTo(AssessmentItem::class, 'mcode', 'mcode');
    }
}
