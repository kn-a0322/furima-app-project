<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;


public function user()
{
    return $this->belongsTo(User::class);
}

public function orders()
{
    return $this->hasMany(Order::class);
}

public function categories()
{
    return $this->belongsToMany(Category::class, 'category_item');
}

public function likes()
{
    return $this->hasMany(Like::class);
}

public function comments()
{
    return $this->hasMany(Comment::class);
}
}
