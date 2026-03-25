<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'image_id', 'quantity', 'producer', 'rating'];

    public function image() {
        return $this->belongsTo(Image::class);
    }
}
