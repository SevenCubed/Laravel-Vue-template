<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bid;
use App\Http\Resources\BidResource;

class BidController extends Controller
{
    public function store(Request $request)
    {
        // $validated = $request->validate([
        //     'amount' => 'required', //why is float not a Laravel validation rule..
        //     'user_id' => 'required|integer',
        //     'product_id' => 'required|integer',
        // ]);
        $bid = Bid::create($request->all());
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
