<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'user_id',
        'profile_photo'
    ];

    protected $appends = [
        'profile_url'
    ];

    public function getProfileUrlAttribute()
    {
        if (empty($this->profile_photo)) {
            return asset('images/icon/user_img.png');
        }

        return asset((env('APP_URL')).\Storage::url('profile/'.$this->profile_photo));
    }

    public function usergroup()
    {
        return $this->hasMany(User::class,'user_id','id');
    }

    public function groupmember()
    {
        return $this->hasMany(ChatGroupMember::class,'group_id','id');
    }

    public function lastMessage()
    {
        return $this->hasOne(ChatMsg::class, 'group_id', 'id')->orderBy('created_at', 'desc');
    }
}
