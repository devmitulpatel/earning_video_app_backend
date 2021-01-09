<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class VideoLike extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'video_likes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'video_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function video()
    {
        return $this->belongsTo(VideoList::class, 'video_id');
    }

    public function like_bies()
    {
        return $this->belongsToMany(User::class);
    }
}
