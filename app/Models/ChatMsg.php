<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\ChatDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatMsg extends Model
{
    use HasFactory;
    protected $appends = [ 'display_time', 'time_diff', 'display_date'];

    public function getDisplayTimeAttribute()
    {
        $timezone = get_user_timezone();
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at, 'UTC');
        return Carbon::parse($date)->setTimezone($timezone)->format('H:i');
    }

    public function getTimeDiffAttribute()
    {
        //$time_diff = new MomentPHP($this->created_at);
        //return $time_diff->fromNow();
    }

    public function getDisplayDateAttribute()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at, 'UTC');
        return $date;
    }
    
    protected $table = 'chat_msgs';
    protected $fillable = [
        'unique_id',
        'message',
        'socket_id',
        'user_id',
        'from',
        'status',
        'message_type',
        'is_msg_encrypted'
    ];
    
    public function User()
    {
        return $this->belongsTo(User::class,'id');
    }
    
    
    public function vendor()
    {
        return $this->belongsTo(User::class, 'from');
    }
    public function vendorShortDetail()
    {
        return $this->belongsTo(User::class, 'from')->select('id', 'name', 'email', 'image as profile_photo_path', 'created_at')->withDefault([
            'id' => 0,
            "name" => "",
            "email" => "",
            "profile_photo_path" => "",
            "created_at" => "",
            "profile_photo_url" => "",
            "profile_url" => ""
        ]);
    }
    
    public function documents()
    {
        return $this->hasMany(ChatDocument::class, 'chat_msg_id');
    }
}
