<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReceipt extends Model
{
    use HasFactory;
    protected $table = 'detailreceipt';
    protected $primaryKey = ['receiptId', 'variantId'];
    public $incrementing = false;
    protected $fillable = ['price', 'quantity', 'deleted'];
}
