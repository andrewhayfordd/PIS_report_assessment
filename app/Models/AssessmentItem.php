<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentItem extends Model
{
    protected $table = 'tblreport_main_items';
    protected $primaryKey = 'transid';
    public $timestamps = false;
    
    protected $fillable = ['fcat', 'scat', 'mcode', 'desc', 'deleted', 'createuser', 'createdate'];
    
    public function secondCategory()
    {
        return $this->belongsTo(SecondCategory::class, 'scat', 'code');
    }
    
    public function firstCategory()
    {
        return $this->belongsTo(FirstCategory::class, 'fcat', 'code');
    }
    
    public function assessments()
    {
        return $this->hasMany(Assessment::class, 'mcode', 'mcode');
    }
}