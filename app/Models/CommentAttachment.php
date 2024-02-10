<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CommentAttachment extends Model
{
    use HasFactory;
    protected $appends = [
        "attachment_url",
        // "mimeType"
    ];

    public function comment()
    {
        return $this->belongsTo(TopicComments::class, 'comment_id');
    }

    public function getAttachmentUrlAttribute()
    {   
        if ($this->attachment) { 
            return url('/comment_attechments/'.$this->attachment);
        }
    }

    // public function getMimeTypeAttribute()
    // {      
    //     if ($this->attachment) { 
    //         return mime_content_type('comment_attechments/'.$this->attachment);
    //     }
    // }
}
