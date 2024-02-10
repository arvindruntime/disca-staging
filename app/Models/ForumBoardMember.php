<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumBoardMember extends Model
{
    use HasFactory;
    protected $table = 'forum_board_member';
    protected $fillable = ['user_id','forum_board_id'];
    protected $hidden = ['created_at','updated_at'];

    public function board()
    {
        return $this->belongsTo(Board::class, 'forum_board_id', 'id');
    }
}
