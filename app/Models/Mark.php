<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;
    protected $table = 'pagemark';
    protected $fillable = [
        'reader_id',
        'book_id',
        'page',
    ];

    public function reader()
    {
        return $this->belongsTo('App\Models\User', 'reader_id');
    }
    public function book()
    {
        return $this->belongsTo('App\Models\Book', 'book_id');
    }
}
