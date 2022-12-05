<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalePromotion extends Model
{
    use HasFactory;
    protected $table = 'salespromotion';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'discount', 'timeStart', 'timeEnd', 'visible', 'mobileBanner', 'pcBanner', 'deleted'];
}
