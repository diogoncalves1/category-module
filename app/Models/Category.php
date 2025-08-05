<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $table = 'category';
    protected $fillable = ['info', 'type', 'icon', 'color', 'default', 'parent_id', 'user_id'];

    public function user()
    {
        // return $this->belongsTo();
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function scopeDefault($query)
    {
        return $query->where('default', 1);
    }
}