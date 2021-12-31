<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comment as CommentModel;

class Tour extends Model
{
    use HasFactory;

    public function comments()
    {
        return $this->hasMany(CommentModel::class);
    }

    protected $table = 'Tour';
}
