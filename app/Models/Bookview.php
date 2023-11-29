<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookview extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'reader_id',
        'book_id',
        'expiration_date',
    ];
}
