<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\ForumTopic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TopicComments extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id','parent_id', 'commented_by','forum_board_id', 'comment_text'
    ];

    protected $hidden = ['topicommentable_id','topicommentable_type','updated_at'];

     
    public function topic()
    {
        return $this->belongsTo(ForumTopic::class, 'topicommentable_id', 'id')->with('board');
    }

    public function replies()
    {
        return $this->hasMany(TopicComments::class, 'parent_id')->with('user')->withCount('likes');
    }

    public function likes()
    {
        return $this->hasMany(ForumLikes::class, 'topic_comment_id','id');
    }

    public function attachments()
    {
        return $this->hasMany(CommentAttachment::class, 'comment_id','id');
    }

    public function topicommentable()
    {
        return $this->morphTo();
    }


    public function user()
    {
        return $this->belongsTo(User::class, 'commented_by');
    }

    public function toArray()
    {
        $array = parent::toArray();

        $array['created_at'] = Carbon::parse($this->attributes['created_at'])
                                    ->format('d M, Y');

        return $array;
    }
}
