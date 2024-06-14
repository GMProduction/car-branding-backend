<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarType extends UuidModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];
}
