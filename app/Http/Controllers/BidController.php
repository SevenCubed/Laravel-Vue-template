<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;
use App\Http\Resources\BidResource;
use App\Events\OverbidEvent;

class BidController extends Controller
{
    public function store(Request $request)
    {
        $bid = Bid::create($request->all());
        $lowerBids = $bid->product->bids->where('amount', '<', $bid->amount)->pluck('user_id')->toArray();
        if(count($lowerBids)){ //if any lower bids exist...
            event(new OverbidEvent($lowerBids));  //dispatch a notification to all users attached to those lower bids. TODO: Make this opt-in, considering it can be really annoying  
        }
        return response()->json(['message' => 'Bid placed!', 'new_bid' => new BidResource($bid)]);
    }
    public function update(Request $request, $id)
    {
        $bid = Bid::find($id);
        $bid->update([
            'amount' => $request['amount'],
        ]);

        return response()->json('Bid updated succesfully!');
    }
    public function destroy($id)
    {
        $product = Bid::find($id);
        $product->delete();

        return response()->json('Bid withdrawn!');
    }
}
