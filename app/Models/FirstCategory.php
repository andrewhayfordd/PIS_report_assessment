<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirstCategory extends Model
{
    protected $table = 'tblreport_first_category';
    protected $primaryKey = 'transid';
    public $timestamps = false;
    
    protected $fillable = ['code', 'desc', 'deleted', 'createuser', 'createdate'];
    
    public function secondCategories()
    {
        return $this->hasMany(SecondCategory::class, 'fcode', 'code')
            ->where('deleted', '0');
    }
}