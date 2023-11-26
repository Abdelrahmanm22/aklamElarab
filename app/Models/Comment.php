<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'reader_id',
        'book_id',
        'created_at',
    ];


    public function book(){
        return $this->belongsTo('App\Models\Book','book_id');
    }

    public function reader(){
        return $this->belongsTo('App\Models\User','reader_id');
    }
}
