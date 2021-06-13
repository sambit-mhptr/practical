@php
$edit = !is_null($dataTypeContent->getKey());
$add  = is_null($dataTypeContent->getKey());
@endphp


@extends('voyager::master')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="/assets/fontawesome-web/css/all.min.css">

@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
<h1 class="page-title">
    <i class="{{ $dataType->icon }}"></i>
    {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
</h1>
@include('voyager::multilingual.language-selector')
@stop

@section('content')
<div class="page-content edit-add container-fluid">
    <div class="row">
        <div class="col-md-12">
            
            <div class="panel panel-bordered">
                <!-- form start -->
                <form role="form"
                class="form-edit-add"
                action="{{ route('voyager.'.$dataType->slug.'.store') }}"
                method="POST" enctype="multipart/form-data">
                
                <!-- CSRF TOKEN -->
                {{ csrf_field() }}
                
                <div class="panel-body">
                    
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    
                    <!-- Adding / Editing -->
                    @php
                    $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                    @endphp
                    
                
<!-- Content here -->
        <div class="form-group  col-md-12">
        <label class="control-label" for="name">Product Name</label>
        <input type="text" id="name" class="form-control" name="name" placeholder="Name" value="{{ old('name') }}" autofocus>
        @error('name')
                <span class="help-block text-danger">{{ $message }}</span>
        @enderror
        </div>
        <div class="form-group  col-md-12">
                <label class="control-label" for="richtextbody">Product Description</label>
                <textarea class="form-control richTextBox" name="description" id="richtextbody" aria-hidden="true">{{ old('description') }}</textarea>
                @error('description')
                <span class="help-block text-danger">{{ $message }}</span>
                @enderror
        </div>                  
        <div class="form-group  col-md-12">
        <label class="control-label" for="price">Product Price</label>
        <input type="text" id="price" class="form-control" name="price" placeholder="Price" value="{{ old('price') }}">
         @error('price')
                <span class="help-block text-danger">{{ $message }}</span>
        @enderror
        </div>       

        <div class="form-group  col-md-12 ">
        <label class="control-label" for="image">Product Image</label>
        <input type="file" id="image" name="image" accept="image/*">
        @error('image')
        <span class="help-block text-danger">{{ $message }}</span>
        @enderror
        </div>

        <div class="form-group col-md-12">
                <label for="price" class="control-label">Categories</label>
            @forelse (auth()->user()->categories as $cat)
            <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $cat->id }}" id="cat-{{ $cat->id }}" name="categories[]"
            @if(is_array(old('categories')) && in_array($cat->id , old('categories')) ) checked @endif>
                    <label class="form-check-label" for="cat-{{ $cat->id }}">
                  <i style="font-size:20px" class="{{ $cat->icon }}"></i>    {{ $cat->name }}
                    </label>
                  </div>
            @empty
                 <a href="/admin/categories/create">Create a category.</a>
            @endforelse 
                
        </div>
<!-- Content here -->
              
                </div><!-- panel-body -->
                
                <div class="panel-footer">
                    @section('submit-buttons')
                    <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                    @stop
                    @yield('submit-buttons')
                </div>
            </form>
            
          {{--   <iframe id="form_target" name="form_target" style="display:none"></iframe>
            <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
            enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
            <input name="image" id="upload_file" type="file"
            onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
            {{ csrf_field() }}
        </form> --}}
        
    </div>
</div>
</div>
</div>

<div class="modal fade modal-danger" id="confirm_delete_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
            </div>
            
            <div class="modal-body">
                <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- End Delete File Modal -->
@stop

@section('javascript')
<script>
    /* tinymce */
$(document).ready(function() {
var additionalConfig = {
selector: 'textarea.richTextBox',
}

$.extend(additionalConfig, "{}")

tinymce.init(window.voyagerTinyMCE.getConfig(additionalConfig));
});
/* tinymce */
    var params = {};
    var $file;
    
    function deleteHandler(tag, isMulti) {
        return function() {
            $file = $(this).siblings(tag);
            
            params = {
                slug:   '{{ $dataType->slug }}',
                filename:  $file.data('file-name'),
                id:     $file.data('id'),
                field:  $file.parent().data('field-name'),
                multi: isMulti,
                _token: '{{ csrf_token() }}'
            }
            
            $('.confirm_delete_name').text(params.filename);
            $('#confirm_delete_modal').modal('show');
        };
    }
    
    $('document').ready(function () {
        $('.toggleswitch').bootstrapToggle();
        
        //Init datepicker for date fields if data-datepicker attribute defined
        //or if browser does not handle date inputs
        $('.form-group input[type=date]').each(function (idx, elt) {
            if (elt.hasAttribute('data-datepicker')) {
                elt.type = 'text';
                $(elt).datetimepicker($(elt).data('datepicker'));
            } else if (elt.type != 'date') {
                elt.type = 'text';
                $(elt).datetimepicker({
                    format: 'L',
                    extraFormats: [ 'YYYY-MM-DD' ]
                }).datetimepicker($(elt).data('datepicker'));
            }
        });
        
        @if ($isModelTranslatable)
        $('.side-body').multilingual({"editing": true});
        @endif
        
        $('.side-body input[data-slug-origin]').each(function(i, el) {
            $(el).slugify();
        });
        
        $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
        $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
        $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
        $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));
        
        $('#confirm_delete').on('click', function(){
            $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                if ( response
                && response.data
                && response.data.status
                && response.data.status == 200 ) {
                    
                    toastr.success(response.data.message);
                    $file.parent().fadeOut(300, function() { $(this).remove(); })
                } else {
                    toastr.error("Error removing file.");
                }
            });
            
            $('#confirm_delete_modal').modal('hide');
        });
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@stop
