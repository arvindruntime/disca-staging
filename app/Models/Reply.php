<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id', 'forum_id', 'comment_user_id', 'replied_by', 'replies', 'status'
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
