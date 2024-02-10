<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ForumTopic extends Model
{
    use HasFactory;
    protected $table = 'forum_topics';
    protected $fillable = [
        'user_id', 'forum_board_id', 'title', 'description', 'status', 'topic_views'
    ];

    protected $hidden = ['updated_at', 'deleted_at'];

    protected $appends = [
        'image_url'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topicComments()
    {
        return $this->morphMany('App\Models\TopicComments', 'topicommentable')->whereNull('parent_id')->orderBy('id', 'DESC');
    }
    
    public function board()
    {
        return $this->belongsTo(Board::class, "forum_board_id", "id");
    }

    public function attachments()
    {
        return $this->hasMany(ForumTopicAttachment::class);
    }

    public function toArray()
    {
        $array = parent::toArray();

        $array['created_at'] = Carbon::parse($this->attributes['created_at'])
                                    ->format('d M, Y');

        return $array;
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) { 
            return url('profile/' . $this->image);
        }
    }

}
