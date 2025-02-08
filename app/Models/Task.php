<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $table = 'task';

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status',
        'person_id',
    ];

    public $timestamps = true;

    /**
     * Get the person that owns the task.
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

}
