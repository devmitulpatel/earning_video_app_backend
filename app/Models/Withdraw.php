<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Withdraw extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'withdraws';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATUS_RADIO = [
        '0' => 'Rejected',
        '1' => 'Processing',
        '2' => 'Accepted',
        '3' => 'Paid',
    ];

    protected $fillable = [
        'user_id',
        'coin_amount',
        'rate',
        'inr_amount',
        'approved_by_id',
        'status',
        'transaction',
        'transaction_data',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approved_by()
    {
        return $this->belongsTo(User::class, 'approved_by_id');
    }
}
