<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        'rate',
        'reader_id',
        'book_id',
        'created_at',
    ];

    public function reader()
    {
        return $this->belongsTo('App\Models\User', 'reader_id');
    }
    public function book()
    {
        return $this->belongsTo('App\Models\Book', 'book_id');
    }

    ///A query scope to retrieve ratings given by a specific user.
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    ///A function to calculate the average rating for a specific book.
    public static function averageRating($bookId)
    {
        return self::where('book_id', $bookId)->avg('rating');
    }

    ///A function to get a specific user's rating for a particular 
    public static function getUserRating($userId, $bookId)
    {
        return self::where('reader_id', $userId)->where('book_id', $bookId)->first();
    }
}
