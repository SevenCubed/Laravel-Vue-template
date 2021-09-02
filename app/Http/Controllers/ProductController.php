<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HTTP\Requests\ProductStoreRequest;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Models\Category;
use App\Models\Image;

//TODO: Clean

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

        return new ProductCollection($products);
    }

    public function categories()
    {
        //TODO: Json
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
        //TODO: Validation opschonen
        $validated = $request->validated();
        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $request['price'],
            'user_id' => $request['user'],
            'status' => 'open',
        ]);
        $product->categories()->sync($validated['categories']);
        $name = $product->id . '-' . time();
        if ($validated['files']){
            $validated['files']->move(public_path('img/'), $name);
            Image::create([
                'product_image_path' => ('img/' . $name),
                'product_id' => $product->id,
            ]);
        }
        else {
            Image::create([
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
        //TODO: Ik weet dat ik deze had versimpelt naar "return ... json(ProductR..)", maar ik heb deze tijdelijk teruggedraaid omdat het onvoorziene problemen oplevert.
        //Blijkbaar zit er toch een (subtiel) verschil tussen, omdat de app de Product->user niet meer kon vinden op een refresh.
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
    public function update(ProductStoreRequest $request, $id)
    {
        //TODO: Fix, RMB, return $product
        // $request->validate([
        //     'name' => 'required',
        //     // 'files' => 'required',
        // ]);
        $validated = $request->validated();
        $product = Product::find($id);
        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'user_id' => $validated['user'],
        ]);

        return response()->json('Product updated succesfully!');
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
