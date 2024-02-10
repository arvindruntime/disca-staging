<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';
    protected $fillable = [
        'title',
        'description',
        'icon',
        'design_type',
    ];

    protected $hidden = [
        'created_at', 
        'updated_at'
    ];

    public function notification_detail()
    {
        return $this->hasMany(NotificationDetail::class, 'notification_id');
    }
}
