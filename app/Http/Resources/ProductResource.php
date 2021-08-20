<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BidResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'status' => $this->status,
            // 'user' => new UserResource($this->user),
            'user' => ['id' => $this->user->id, 'name' => $this->user->name, 'created_at' => $this->user->created_at],
            'card_image' => $this->images[0]->product_image_path,
            'categories' => $this->categories[0]->name,
            'created_at' => $this->created_at->format('j F Y, H:i'),
            'updated_at' => $this->updated_at,
            // 'bids' => [ 'id' => $this->bids->id, 'amount' => $this->bids->amount, 'timestamp' => $this->bids->updated_at->format('j F Y'), 'user' => $this->bids()->user->name ],
            'bids' => BidResource::collection($this->bids),
        ];
    }
}
