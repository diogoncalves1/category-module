<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['info', 'type', 'icon', 'color', 'default', 'parent_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function scopeDefault($query, $default)
    {
        return $query->where('default', $default);
    }

    public function scoprUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
    public function getTranslatedName($lang)
    {
        return data_get($this->info, "$lang.name");
    }
}