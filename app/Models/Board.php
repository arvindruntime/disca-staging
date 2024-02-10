<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Board extends Model
{
    use HasFactory;
    protected $table = 'forum_board';
    protected $fillable = ['user_id','board_name','url','discription','image','members'];
    protected $hidden = ['created_at','updated_at'];

    protected $appends = [
        'image_url'
    ];

    public function getImageUrlAttribute() {
        if ($this->image) { 
            return url('forum_board/' . $this->image);
        }
    }
    public function members(): HasManyThrough
    {
        return $this->hasManyThrough(
            User::class,
            ForumBoardMember::class,
            'forum_board_id', // Foreign key on the environments table...
            'id', // Local key on the projects table...
            'id', // Local key on the environments table...
            'user_id', // Foreign key on the deployments table...
        );
    }
}
