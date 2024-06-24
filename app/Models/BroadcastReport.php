<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class BroadcastReport extends UuidModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'image',
        'type',
        'latitude',
        'longitude',
        'date',
        'broadcast_name'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
