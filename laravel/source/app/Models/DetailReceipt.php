<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailReceipt extends Model
{
    use HasFactory;
    protected $table = 'detailreceipt';
    protected $primaryKey = ['receiptId', 'receiptId'];
    protected $fillable = ['price', 'quantity', 'deleted'];
}
