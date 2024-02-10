<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChatDocument extends Model
{
    use HasFactory;

    protected $appends = [
        'document_url', 'display_time'
    ];

    public function getDisplayTimeAttribute()
    {
        return Carbon::parse($this->created_at)->format('d-m-Y h:i A');
    }

    /**
     * Get the chatMsg that owns the ChatDocument
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chatMsg()
    {
        return $this->belongsTo(ChatMsg::class, 'chat_msg_id');
    }

    public function getDocumentUrlAttribute()
    {
        if (isset($this->chatMsg->vendor)) {
            return asset('storage/chats/' . $this->chatMsg->vendor->id . '/' . $this->document);
        } else {
            return false;
        }
    }
}
