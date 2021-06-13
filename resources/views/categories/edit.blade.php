@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
            @if(session()->has('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
            @endif
      <div class="card">
        <div class="card-header">Edit Category</div>
        <div class="card-body">
                <form  method="POST" action="/categories/{{ $category->id }}">
                    @csrf
                    @method('PUT')
                        <div class="form-group">
                          <label for="name" class="text-muted">Category Name</label>
                          <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}">
                          {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                          @error('name')
                          <small class="form-text text-danger">{{ $message }}</small>
                          @enderror
                        </div>

                        <div class="form-group">
                                <label for="icon" class="text-muted">Category Icon</label>
                                <input type="text" class="form-control" id="icon" name="icon" value="{{ $category->icon }}">
                                <small class="form-text text-muted">choose from <a href="https://fontawesome.com/v5.15/icons?d=gallery&p=2&m=free" target="_blank">font awesome</a>.</small>
                                @error('icon')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                        </div>

                        
                        <button type="submit" class="btn btn-primary">Update</button>
                      </form>
          
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('foot-scripts')


@endpush
