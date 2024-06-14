<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends UuidModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'car_type_id',
        'name',
        'vehicle_id',
        'phone',
        'account_number',
        'bank'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function car_type()
    {
        return $this->belongsTo(CarType::class,'car_type_id');
    }
}
