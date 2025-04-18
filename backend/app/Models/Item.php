<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'status',
        'location',
        'created_by',
        'category_id',
        'file_path',
        'file_name',
        'file_type',
    ];

    protected $appends = [
        'image_url',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category()
    {
        return $this->belongTo(Category::class);
    }

    public function getImageUrlAttribute(): string
    {
        return Storage::url(sprintf('%s/%s', $this->file_path, $this->file_name));
    }
}
