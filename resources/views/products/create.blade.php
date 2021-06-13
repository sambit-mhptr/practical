@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card">
        <div class="card-header">Add Product</div>
        <div class="card-body">
                <form  method="POST" action="/products" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                          <label for="name" class="text-muted">Product Name</label>
                          <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                          {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                          @error('name')
                          <small class="form-text text-danger">{{ $message }}</small>
                          @enderror
                        </div>
                        <div class="form-group">
                                <label for="description" class="text-muted">Product Description</label>
                                <textarea class="form-control richTextBox" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                                @error('description')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                        </div>
                        <div class="form-group">
                                <label for="price" class="text-muted">Product Price</label>
                                <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}">
                                {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                @error('price')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                        </div>
                        <div class="form-group">
                                <label for="price" class="text-muted">Product Image</label>
                                <input type="file" class="form-control" id="image" name="image">
                                {{-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> --}}
                                @error('image')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                        </div>

                        <div class="form-group">
                                <label for="price" class="text-muted">Categories</label>
                            @forelse (auth()->user()->categories as $cat)
                            <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $cat->id }}" id="cat-{{ $cat->id }}" name="categories[]"
@if(is_array(old('categories')) && in_array($cat->id , old('categories')) ) checked @endif>
                                    <label class="form-check-label" for="cat-{{ $cat->id }}">
                                  <i style="font-size:20px" class="{{ $cat->icon }}"></i>    {{ $cat->name }}
                                    </label>
                                  </div>
                            @empty
                                 <a href="/categories/create">Create a category.</a>
                            @endforelse 
                                
                        </div>

                        
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
          
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('foot-scripts')
<script src="/assets/tinymce/jquery.tinymce.min.js"></script>
<script src="/assets/tinymce/tinymce.min.js"></script>
<script>
$(document).ready(function() {
var additionalConfig = {
  menubar: false,
    selector:'textarea.richTextBox',
  //  skin_url: $('meta[name="assets-path"]').attr('content')+'?path=js/skins/voyager',
    min_height: 350,
    resize: 'vertical',
    plugins: 'link, image, code, table, textcolor, lists',
    extended_valid_elements : 'input[id|name|value|type|class|style|required|placeholder|autocomplete|onclick]',
    file_picker_callback: function (cb, value, meta) {
      var input = document.createElement('input');
      input.setAttribute('type', 'file');
      input.setAttribute('accept', 'image/*');

      /*
        Note: In modern browsers input[type="file"] is functional without
        even adding it to the DOM, but that might not be the case in some older
        or quirky browsers like IE, so you might want to add it to the DOM
        just in case, and visually hide it. And do not forget do remove it
        once you do not need it anymore.
      */

      input.onchange = function () {
        var file = this.files[0];

        var reader = new FileReader();
        reader.onload = function () {
          /*
            Note: Now we need to register the blob in TinyMCEs image blob
            registry. In the next release this part hopefully won't be
            necessary, as we are looking to handle it internally.
          */
          var id = 'blobid' + (new Date()).getTime();
          var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
          var base64 = reader.result.split(',')[1];
          var blobInfo = blobCache.create(id, file, base64);
          blobCache.add(blobInfo);

          /* call the callback and populate the Title field with the file name */
          cb(blobInfo.blobUri(), { title: file.name });
        };
        reader.readAsDataURL(file);
      };

      input.click();
    },
    toolbar: 'styleselect bold italic underline | forecolor backcolor | alignleft aligncenter alignright | bullist numlist outdent indent | link image table | code',
    convert_urls: false,
    image_caption: true,
    image_title: true,
};
tinymce.init(additionalConfig);


});
</script>
@endpush

@push('head-scripts')
<link rel="stylesheet" href="/assets/fontawesome-web/css/all.min.css">

@endpush
