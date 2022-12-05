<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $table = 'receipt';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'timeOrder', 'paymentTime', 'paymentMethod'];
}
