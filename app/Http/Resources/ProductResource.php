<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\BidResource;
use Illuminate\Support\Facades\DB;
use App\Models\Bid;

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
        //TODO: Combine these 3 and check result -> Make laravel do it all at once, somehow
        $lat = DB::select("select latitude from 4pp where postcode = {$this->user->postal_code}")[0]->latitude;
        $long = DB::select("select longitude from 4pp where postcode = {$this->user->postal_code}")[0]->longitude;
        $location = DB::select("select woonplaats from 4pp where postcode = {$this->user->postal_code}")[0]->woonplaats;

        $coordinates = [$lat, $long];
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'status' => $this->status,
            'user' => ['id' => $this->user->id, 'name' => $this->user->name, 'created_at' => $this->user->created_at, 'coordinates' => $coordinates , 'location' => $location],
            'card_image' => $this->images[0]->product_image_path,
            'categories' => $this->categories[0]->name,
            'created_at' => $this->created_at->format('j F Y, H:i'),
            'updated_at' => $this->updated_at,
            'bids' => BidResource::collection($this->bids),
            'reserved_bid' => $this->reserved_bid_id ? Bid::find($this->reserved_bid_id) : null,
        ];
    }
}
