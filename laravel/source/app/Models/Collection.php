<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;
    protected $table = 'collection';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'visible', 'mobileBanner', 'pcBanner', 'deleted'];
}
