<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationDetail extends Model
{
    use HasFactory;
    protected $table = 'notification_details';
    protected $fillable = [
        'notification_id',
        'title',
        'detail_description',
        'icon',
        'status',
        'is_hide'
    ];

    protected $hidden = [
        'created_at', 
        'updated_at',
        'notification_id'
    ];

    public function notification()
    {
        return $this->belongsTo(Notification::class, 'notification_id');
    }
}
