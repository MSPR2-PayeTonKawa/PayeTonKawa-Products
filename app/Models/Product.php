<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Category;

class Product extends Model
{
    public $incrementing = false; // UUID
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'origin',
        'price',
        'stock',
        'category_id'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
