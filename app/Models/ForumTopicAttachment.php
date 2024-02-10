<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumTopicAttachment extends Model
{
    use HasFactory;

    public function topics()
    {
        return $this->belongsToMany(ForumTopic::class, 'forum_topic_attachment');
    }
}
