<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'img',
        'admin_id',
    ];

    public function admin(){
        return $this->belongsTo('App\Models\User','admin_id');
    }
}
