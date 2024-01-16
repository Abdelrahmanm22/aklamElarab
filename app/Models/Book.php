<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'file',
        'rate',
        'view',
        'author_id',
        'admin_id',
    ];

    public function author(){
        return $this->belongsTo('App\Models\User','author_id');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment','book_id','id');
    }

    public function ratings(){
        return $this->hasMany('App\Models\Rating','book_id','id');
    }

    public function marks(){
        return $this->hasMany('App\Models\Mark','book_id','id');
    }

    public static function updateAverageRating($bookId)
    {
        $book = self::find($bookId);

        if ($book) {
            $book->update([
                'rate' => round($book->ratings()->avg('rate'), 1),                
            ]);
        }
    }
    public static function incrementView($bookId)
    {
        $book = self::find($bookId);

        if ($book) {
            $book->update([
                'view' => $book->view + 1,
            ]);
        }
    }
    public function libraries()
    {
        return $this->belongsToMany(Library::class,'library_book');
    }

}
