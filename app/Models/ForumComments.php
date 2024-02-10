<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumComments extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic_id', 'commented_by', 'comments', 'forum_id', 'status'
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function toArray()
    {
        $array = parent::toArray();

        $array['created_at'] = Carbon::parse($this->attributes['created_at'])
                                    ->format('d M, Y');

        return $array;
    }
}
