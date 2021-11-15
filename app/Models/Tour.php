<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    public function getComments()
    {
        return $this->belongsToMany(self::class, Comment::class, 'tour_id', 'id');
    }

    protected $table = 'tour';
}
