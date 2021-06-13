@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      @if(session()->has('status'))
      <div class="alert alert-success">{{ session('status') }}</div>
      @endif
      <div class="card">
        <div class="card-header">Categories <a href="categories/create"  class="btn btn-primary text-white ml-3">Add Category</a>
        </div>
        <div class="card-body">
          
          <table class="table" id="categoryTable">
            <thead class="thead-dark">
              <tr>
                <th width="5%" scope="col">#</th>
                <th scope="col">Category Name</th>
                <th scope="col">Category Icon</th>
                <th scope="col" width="30%">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($categories as $category)
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $category->name }}</td>               
                <td><i style="font-size:30px" class="{{ $category->icon }}"></i> {{ $category->icon }}</td>
                <td style="text-align:center"> 
                  <a class="btn btn-sm btn-warning" href="categories/{{ $category->id }}">View</a>
                  @if(isset(auth()->user()->id) && (auth()->user()->id == $category->user_id) ) 
                  <a class="btn btn-sm btn-success ml-1" href="categories/{{ $category->id }}/edit">Edit</a>
                  <form action="categories/{{ $category->id }}" method="POST" style="display:inline" onsubmit="delete_submit(event)">
                    @csrf
                    @method('DELETE') 
                  <button type="submit" class="btn btn-sm btn-danger ml-1">Delete</button>
                </form>
                  @endif
                </td>
              </tr>
              @empty
              <tr><td colspan="5" style="text-align:center">No Categories created yet!</td></tr>
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
    $('#categoryTable').DataTable();
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

<link rel="stylesheet" href="/assets/fontawesome-web/css/all.min.css">
@endpush
