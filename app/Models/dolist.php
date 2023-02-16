<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dolist extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'desc','status_id'];
    public function Status()
    {
      return $this->belongsTo(status::class,'status_id','id');
    }
}
