<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplyForCareResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' =>$this->id,
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
            'apply_person_name' => $this->apply_person_name,
            'relationship' => $this->relationship,
            'street' => $this->street,
            'city' => $this->city,
            'country' => $this->country,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'mobile_number' => $this->mobile_number,
            'required_care' => $this->required_care,
            'description' => $this->description,
            'specialist_care' => $this->specialist_care,
            'term_condition' => $this->term_condition,
        ];
    }
}
