<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecondCategory extends Model
{
    protected $table = 'tblreport_second_category';
    protected $primaryKey = 'transid';
    public $timestamps = false;
    
    protected $fillable = ['code', 'fcode', 'desc', 'deleted', 'createuser', 'createdate'];
    
    public function firstCategory()
    {
        return $this->belongsTo(FirstCategory::class, 'fcode', 'code');
    }
    
    public function assessmentItems()
    {
        return $this->hasMany(AssessmentItem::class, 'scat', 'code')
            ->where('deleted', '0');
    }
}