<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HTTP\Requests\ProductStoreRequest;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Models\Category;
use App\Models\Image;

class ProductController extends Controller
{
    // public function __construct()
    // {
    //   $this->middleware('auth:api');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        // CR :: return altijd een json response 'https://laravel.com/docs/8.x/responses#json-responses' 
        // AFAIK the Resource Collection is already in json. It definitely seems to be that way in Tools->Network->Request->Response
        return new ProductCollection($products);
    }

    public function categories()
    {
        return Category::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $validated = $request->validated();
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $request['price'],
            'user_id' => $request['user'],
            'status' => 'open',
        ]);
        $categories = json_decode($request['categories'],true);
        $product->categories()->sync($categories['categories']);
        $name = $product->id . '-' . time();
        if ($validated['files']){
            $validated['files']->move(public_path('img/'), $name);
            $image = Image::create([
                'product_image_path' => ('img/' . $name),
                'product_id' => $product->id,
            ]);
        }
        else {
            $image = Image::create([
                'product_image_path' => ('img/placeholder'),
                'product_id' => $product->id,
            ]);
        }
        return response()->json('Success! (I think)');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // CR :: return altijd een json response 'https://laravel.com/docs/8.x/responses#json-responses' 
        $product = new ProductResource($product);
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            // 'files' => 'required',
        ]);
        $product = Product::find($id);
        $product->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'price' => $request['price'],
            'user_id' => $request['user'],
        ]);

        return response()->json('Product update succesfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return response()->json('Product succesfully deleted!');
    }
}
