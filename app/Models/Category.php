<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function getPhotoAttribute($value)
    {
        return $value === null ? 'No Photo' : asset('storage/' . $value);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
