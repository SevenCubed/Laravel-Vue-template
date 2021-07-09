<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'files'=> 'required',
        ]);
        // $name = $request['user'] . '.' . time();
        // $request['files']->save(public_path('img/'), $name);
        // $image = Image::create(['product_image_path' => 'img'.$name]);
        $product = Product::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'price' => $request['price'],
            'user_id' => $request['user'],
            'status' => 'open',
       ]);
       $product->categories()->sync(Category::all()->random());
       $name = $product->id . '-' . time();
       $request['files']->move(public_path('img/'), $name);
       $image = Image::create([
           'product_image_path' => ('img/'.$name),
           'product_id' => $product->id,
       ]);
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
        return new ProductResource($product);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
