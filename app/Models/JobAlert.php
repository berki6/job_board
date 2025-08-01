<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobAlert extends Model
{
    protected $fillable = ['user_id', 'keywords', 'location', 'category_id', 'job_type_id', 'frequency'];

    protected $casts = [
        'keywords' => 'array',
        'location' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }
}
