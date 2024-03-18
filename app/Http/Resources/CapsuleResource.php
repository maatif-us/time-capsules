<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CapsuleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // $remainingTime = $this->remaining_time;
        return [
            'id' => $this->id,
            'message' => $this->message,
            'openeingTime' => $this->openeing_time,
            'isOpened' => !!$this->opened_at,
            // 'remainingTime' => $remainingTime, // in Millis
            // 'openedBy' => UserResource::make($this->opened_by), 
        ];
    }
}
