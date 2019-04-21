<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'full_name'  => $this->full_name,
            'user_name'  => $this->user_name,
            'email'      => $this->email,
            'active'     => ($this->active) ? true : false,
            'created_at' => Carbon::parse($this->created_at)->toDateTimeString(),
            'created_by' => ($this->created_by) ? $this->createdBy->full_name : null
        ];
    }
}
