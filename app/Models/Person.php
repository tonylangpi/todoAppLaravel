<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Person extends Model
{
    //
    use HasFactory;

    protected $table = 'person';

    protected $fillable = [
        'name',
        'email',
        'code',
        'phone',
    ];
}
