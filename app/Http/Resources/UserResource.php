<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

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
        $lat = DB::select("select latitude from 4pp where postcode = {$this->postal_code}")[0]->latitude;
        $long = DB::select("select longitude from 4pp where postcode = {$this->postal_code}")[0]->longitude;
        $location = DB::select("select woonplaats from 4pp where postcode = {$this->postal_code}")[0]->woonplaats;
        $coordinates =  [$lat, $long];

        return [    
        'id' => $this->id,
        'name' => $this->name,
        'email' => $this->email,
        'postal_code' => $this->postal_code,
        'created_at' => $this->created_at,
        'coordinates' => $coordinates,
        'location' => $location,
        ];
    }
}
