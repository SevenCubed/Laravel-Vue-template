<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BidResource extends JsonResource
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
            'id' => $this->id,    
            'amount' => $this->amount,
            'timestamp' => $this->updated_at->format('j-m-Y'),
            'user' => $this->user->name,
            'user_id' => $this->user->id,
        ];
    }
}
