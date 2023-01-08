<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    use HasFactory;
    protected $table = 'variation';
    protected $primaryKey = 'id';
    protected $fillable = ['productId', 'colorId', 'thumbnail', 'deleted'];

    public function Sizes()
    {
        return $this->hasMany(Size::class, 'variantId', 'id');
    }

    public function Images()
    {
        return $this->hasMany(Image::class, 'variantId', 'id');
    }
}
