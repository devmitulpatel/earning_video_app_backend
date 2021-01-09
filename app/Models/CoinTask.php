<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class CoinTask extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'coin_tasks';

    const SINGLE_TASK_RADIO = [
        '0' => 'off',
        '1' => 'on',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'description',
        'coin_earn',
        'single_task',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function task_finished_bies()
    {
        return $this->belongsToMany(User::class);
    }
}
