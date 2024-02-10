<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplyForCare extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "apply_for_care";
    protected $fillable = ['user_id',
        'user_name',
        'apply_person_name',
        'relationship',
        'street',
        'city',
        'country',
        'post_code',
        'email',
        'telephone',
        'mobile_number',
        'required_care',
        'description',
        'specialist_care',
        'term_condition'
    ];
}
