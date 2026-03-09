<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'image_path',
        'condition',
        'is_sold',
    ];


public function user()
{
    return $this->belongsTo(User::class);
}

public function order()
{
    return $this->hasOne(Order::class);
}

public function categories()
{
    return $this->belongsToMany(Category::class, 'category_item');
}

public function likes()
{
    return $this->hasMany(Like::class);
}
public function isLikedBy($user)
{
    return $this->likes->where('user_id', $user->id)->count() > 0;
}

public function comments()
{
    return $this->hasMany(Comment::class);
}

public function getConditionAttribute()
{
    $conditions = [
        'good' => '良好',
        'no_major_damage' => '目立った傷や汚れなし',
        'slight_damage' => 'やや傷や汚れあり',
        'poor' => '状態が悪い',
    ];
    return $conditions[$this->attributes['condition']] ?? $this->attributes['condition'];
}
}
