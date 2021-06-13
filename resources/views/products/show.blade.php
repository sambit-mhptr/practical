@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
             <div class="text-center display-4"> View Product</div>  
            <div class="card p-3">
                <div><h5>Product Name</h5></div> 
                <div class="card-body">
                   {{ $product->name }}    
                </div>      
            </div>
            <hr class="bg-black">

            <div class="card p-3">
                    <div><h5>Product Description</h5></div> 
                    <div class="card-body">
                       {!! $product->description !!}    
                    </div>      
            </div>
            <hr class="bg-black">

                <div class="card p-3">
                        <div><h5>Product Price</h5></div> 
                        <div class="card-body">
                           {{ $product->price }}    
                        </div>      
                </div>
                <hr class="bg-black">

                <div class="card p-3">
                        <div><h5>Product Image</h5></div> 
                        <div class="card-body">
                            @if($product->image && file_exists('storage/products'.$product->image))
                            <img src="{{ asset('storage/products'.$product->image) }}" class="img-fluid">
                            @else
                            No image found
                            @endif    
                        </div>      
                </div>
                <hr class="bg-black">

                <div class="card p-3">
                        <div><h5>Product Categories</h5></div> 
                        <div class="card-body">
                           @forelse ($product->categories as $cat)
                         <i class="{{ $cat->icon }}"></i>  {{ $cat->name }}  <br/>     
                           @empty
                               No category found!
                           @endforelse   
                        </div>      
                    </div>
        </div>
    </div>
</div>
@endsection

