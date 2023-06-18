<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description'
    ];

    protected $table = "categories";

    public function categories()
    {
        return $this->hasMany(Category::class, 'category_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function targets()
    {
        return $this->belongsToMany(Target::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function isFather()
    {
        return is_null($this->attributes['category_id']);
    }

    protected $appends = ['is_father'];
    public function getIsFatherAttribute()
    {
        return is_null($this->attributes['category_id']);
    }

}
