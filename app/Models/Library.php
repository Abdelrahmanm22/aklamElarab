<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;
    protected $fillable = [
        'reader_id',
    ];

    public function reader(){
        return $this->belongTo('App\Models\User','reader_id');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class,'library_book');
    }
    public static function createLibrary($id){
        Library::create([
            'reader_id'=>$id,
        ]);
    }
}
