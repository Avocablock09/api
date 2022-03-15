<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JalanResource extends JsonResource
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
            'point_id'=>$this->point_id,
            'latitude'=>$this->latitude,
            'longitude'=>$this->longitude,
            'status'=>$this->status
        ];
    }
}
