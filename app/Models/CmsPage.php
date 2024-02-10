<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CmsPage extends Model
{
    use HasFactory;
    protected $table = 'cms_pages';
    protected $fillable = [
        'description',
    ];
    protected $hidden = [
        'created_at', 
        'updated_at',
        'id',
        'type'
    ];
}
