<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\File;


class ProductController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $products =  Product::latest()->get();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //dd($request->all());
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'nullable|numeric',
            'image' => 'nullable|mimes:jpg,bmp,png,jpeg'
        ]);
        
       $p = new Product();
       $p->user_id = auth()->user()->id;
       $p->name= $request->name;
       $p->description = $request->description;
       $p->price = $request->price;

       if($request->hasFile('image')){
      $path = $request->image->store('public/products');
      $path =  strrchr($path, '/');
        $p->image = $path;
       }
       $p->save();

       //store categories
       //dd($p->id);
     /*   foreach($request->categories as $c){

        \DB::table('category_product')->insert();
        
       } */
       $p->categories()->attach($request->categories);//on edit sync
       return redirect('/products')->with('status', 'Product is created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product) 
    {
        if(auth()->user()->id != $product->user_id){
            abort('403', 'unauthorized');
        }
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Product $product)
    {
        if(auth()->user()->id != $product->user_id){
            abort('403', 'unauthorized');
        }
        //dd($request->all());
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'nullable|numeric',
            'image' => 'nullable|mimes:jpg,bmp,png,jpeg'
        ]);
        
       $p = $product;
       $p->user_id = auth()->user()->id;
       $p->name= $request->name;
       $p->description = $request->description;
       $p->price = $request->price;

       if($request->hasFile('image')){
        //unlink the previous image
        if(file_exists('storage/products'.$p->image)){
            \File::delete('storage/products'.$p->image);
        }
        
      $path = $request->image->store('public/products');
      $path =  strrchr($path, '/');
        $p->image = $path;
       }
       $p->save();
       $p->categories()->sync($request->categories);//on edit sync
       return redirect('/products/'.$p->id.'/edit')->with('status', 'Product is updated successfully!');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if(auth()->user()->id != $product->user_id){
            abort('403', 'unauthorized');
        }
         //unlink the previous image
         if($product->image && file_exists('storage/products'.$product->image)){
            File::delete('storage/products'.$product->image);
        }
        $product->delete();
        
        return redirect('/products')->with('status', 'Product is deleted successfully!');

    }
}
