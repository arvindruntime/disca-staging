<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Country;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {        
        return
            [
                'id' => $this->id,
                'name' => $this->name,
                'username' => $this->username,
                'email' => $this->email,
                'profile_image' => $this->image,
                'user_type' => (int)$this->user_type,
                'account_type' => (int)$this->account_type,
                'status' => $this->status ?? 1,
                'microsoft2fa_secret' => $this->microsoft2fa_secret,
                'microsoft2fa_status' => $this->microsoft2fa_status ?? 0,
                'company' => $this->company,
                'company_lead' => $this->company_lead,
                'organization' => $this->organization,
                'country' => new CountryResource($this->country),
                'street' => $this->street,
                'city' => $this->city,
                'post_code' => $this->post_code,
                'dial_code' => new CountryResource($this->dialCode),
                'mobile_no' => $this->mobile_no,
                'phone_dial_code' => new CountryResource($this->phoneDialCode),
                'phone_no' => $this->phone_no,
                'website' => $this->website,
                'sectore' => $this->sectore,
                'otp' => $this->otp,
                'terms_and_condition' => $this->terms_and_condition ?? 1,
                'fcm_token' => $this->fcm_token,
                'email_status' => $this->email_status ?? 0,
                'notification_status' => $this->notification_status ?? 0,
                'profile_image_url' => $this->profile_image_url,
            ];
    }
}
