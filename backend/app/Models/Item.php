<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'price',
        'status',
        'location',
        'user_id',
        'category_id',
    ];

    public function user()
    {
        return $this->belongTo(User::class);
    }

    public function category()
    {
        return $this->belongTo(Category::class);
    }
}
