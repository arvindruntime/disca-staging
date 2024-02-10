<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumBoardActivities extends Model
{
    use HasFactory;
    protected $table = 'forum_board_activities';
    protected $fillable = ['user_id','forum_board_id','topic_id', 'followers'];
    protected $hidden = ['created_at','updated_at'];

    public function board()
    {
        return $this->belongsTo(Board::class, 'forum_board_id', 'id');
    }

    public function topic()
    {
        return $this->belongsTo(ForumTopic::class, 'topic_id', 'id');
    }
}
