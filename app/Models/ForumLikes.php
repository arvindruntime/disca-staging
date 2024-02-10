<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumLikes extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'topic_id', 'user_id', 'topic_comment_id','is_like',
    ];

    protected $hidden = ['created_at', 'updated_at'];
}
