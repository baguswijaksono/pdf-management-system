<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $fillable = ['userId','title','category_id','description','quantity','image','pdf'];

    public function category()
{
    return $this->belongsTo(Categories::class, 'category_id');
}
    use HasFactory;
}
