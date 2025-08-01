<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    /** @use HasFactory<\Database\Factories\JobTypeFactory> */
    use HasFactory;

    protected $table = 'job_types';

    protected $fillable = ['name'];

    public function jobs()
    {
        return $this->hasMany(Job::class, 'job_type_id');
    }
}
