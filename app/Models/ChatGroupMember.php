<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatGroupMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'user_id',
    ];
    
    protected $dates = ['deleted_at'];

    public function group()
    {
        return $this->hasMany(ChatGroup::class,'user_id','id');
    }

    public function vendor()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id', 'name', 'email', 'image as profile_photo_path', 'created_at')->withDefault([
            'id' => 0,
            "name" => "",
            "email" => "",
            "profile_photo_path" => "",
            "created_at" => "",
        ]);
    }
}
