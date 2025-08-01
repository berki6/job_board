<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Get the jobs in this category.
     */
    public function jobs()
    {
        return $this->hasMany(Job::class, 'category_id');
    }
}
