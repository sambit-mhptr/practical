@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      @if(session()->has('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
      @endif
      <div class="card">
        <div class="card-header">Products <a href="products/create"  class="btn btn-primary text-white ml-3">Add Product</a>
        </div>
        <div class="card-body">
          
          <table class="table" id="productsTable">
            <thead class="thead-dark">
              <tr>
                <th width="5%" scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Image</th>
                <th scope="col">Price</th>
                <th scope="col" width="30%">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($products as $product)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $product->name }}</td>
                <td>
@if($product->image && file_exists('storage/products'.$product->image))
<img src="{{ asset('storage/products'.$product->image) }}" style="width:100px">
@else
No image found
@endif
                </td>
                <td>{{ $product->price }}</td>
                <td style="text-align:center"> 
                  <a class="btn btn-sm btn-warning" href="products/{{ $product->id }}">View</a>
                  @if(isset(auth()->user()->id) && (auth()->user()->id == $product->user_id) ) 
                  <a class="btn btn-sm btn-success ml-1" href="products/{{ $product->id }}/edit">Edit</a>
                  <form action="products/{{ $product->id }}" method="POST" style="display:inline" onsubmit="delete_submit(event)">
                    @csrf
                    @method('DELETE') 
                  <button type="submit" class="btn btn-sm btn-danger ml-1">Delete</button>
                </form>
                  @endif
                </td>
              </tr>
              @empty
              <tr><td colspan="5" style="text-align:center">No products created yet!</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('foot-scripts')
<script src="http://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready( function () {
    $('#productsTable').DataTable();
  } );
 function delete_submit(e){
  if(!confirm('Are you sure you want to delete this?'))
  {
            e.preventDefault();
  }

  
 }
</script>

@endpush

@push('head-scripts')
<link rel="stylesheet" href="http://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

@endpush
