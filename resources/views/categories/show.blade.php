@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
             <div class="text-center display-4"> View Category</div>  
            <div class="card p-3">
                <div><h5>Category Name</h5></div> 
                <div class="card-body">
                   {{ $category->name }}    
                </div>      
            </div>
            <hr class="bg-black">
                <div class="card p-3">
                        <div><h5>Category Icon</h5></div> 
                        <div class="card-body">
                            <i style="font-size:30px" class="{{ $category->icon }}"></i>    {{ $category->icon }}    
                        </div>      
                </div>
            </div>
    </div>
</div>
@endsection


@push('head-scripts')
<link rel="stylesheet" href="/assets/fontawesome-web/css/all.min.css">

@endpush

