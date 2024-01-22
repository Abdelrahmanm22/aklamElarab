<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
///This Model for Data related to the author 
class Related extends Model
{
    use HasFactory;
    protected $table = 'relatedauthor';

    protected $fillable = [
        'id',
        'author_id',
        'facebook',
        'twitter',
        'about',
    ];

    public function author(){
        return $this->belongTo('App\Models\User','author_id');
    }
}
