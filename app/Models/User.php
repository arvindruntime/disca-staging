<?php

namespace App\Models;

use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array

     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'image',
        'user_type',
        'account_type',
        'status',
        'microsoft2fa_secret',
        'microsoft2fa_status',
        'company',
        'company_lead',
        'organization',
        'country_id',
        'street',
        'city',
        'post_code',
        'dial_code',
        'mobile_no',
        'phone_dial_code',
        'phone_no',
        'website',
        'sectore',
        'otp',
        'terms_and_condition',
        'fcm_token',
        'email_status',
        'notification_status',
        'profile_image_url',
    ];

    protected $appends = [
        'profile_image_url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array

     */
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at',
        'updated_at',
        'token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array

     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Interact with the user's first name.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function type(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  ["forum_user", "admin", "provider", "user"][$value],
        );
    }

    public function toArray()
    {
        $array = parent::toArray();

        $array['created_at'] = Carbon::parse($this->attributes['created_at'])
                                    ->format('d M, Y');

        return $array;
    }

    public function getProfileImageUrlAttribute()
    {

        if ($this->image) {
            return url('/profile/' . $this->image);
        }
        else{
            return asset('images/icon/table-user.png');
        }
    }

    public function getTokenAttribute()
    {
        if (Auth::check()) {
            return Auth::user()->createToken('DiscaToken')->accessToken;
        }
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function dialCode()
    {
        return $this->belongsTo(Country::class, 'dial_code', 'dial_code');
    }

    public function phoneDialCode()
    {
        return $this->belongsTo(Country::class, 'phone_dial_code', 'dial_code');
    }
}
