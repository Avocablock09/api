<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ViolationResource extends JsonResource
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
            'id_pelanggaran' => $this->id_pelanggaran,
            'id_user' => $this->id_user,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'time_start'=> $this->time_start,
            'time_end' => $this->time_end
        ];
    }
}
