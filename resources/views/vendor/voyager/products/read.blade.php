@extends('voyager::master')

@section('page_title', __('voyager::generic.view').' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }} {{ ucfirst($dataType->getTranslatedAttribute('display_name_singular')) }} &nbsp;

        @can('edit', $dataTypeContent)
            <a href="{{ route('voyager.'.$dataType->slug.'.edit', $dataTypeContent->getKey()) }}" class="btn btn-info">
                <i class="glyphicon glyphicon-pencil"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.edit') }}</span>
            </a>
        @endcan
        @can('delete', $dataTypeContent)
            @if($isSoftDeleted)
                <a href="{{ route('voyager.'.$dataType->slug.'.restore', $dataTypeContent->getKey()) }}" title="{{ __('voyager::generic.restore') }}" class="btn btn-default restore" data-id="{{ $dataTypeContent->getKey() }}" id="restore-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.restore') }}</span>
                </a>
            @else
                <a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete" data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
                </a>
            @endif
        @endcan
        @can('browse', $dataTypeContent)
        <a href="{{ route('voyager.'.$dataType->slug.'.index') }}" class="btn btn-warning">
            <i class="glyphicon glyphicon-list"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.return_to_list') }}</span>
        </a>
        @endcan
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    
                    <!-- form start -->
                    <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">Name</h3>
                        </div>

                        <div class="panel-body" style="padding-top:0;">
                                <p>{{ $dataTypeContent->name }}</p>
                        </div>
                        <hr style="margin:0;">

                        <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Description</h3>
                            </div>
    
                            <div class="panel-body" style="padding-top:0;">
                                    <p>{!! $dataTypeContent->description !!}</p>
                            </div>
                            <hr style="margin:0;">
                        
                            <div class="panel-heading" style="border-bottom:0;">
                                    <h3 class="panel-title">Price</h3>
                                </div>
        
                                <div class="panel-body" style="padding-top:0;">
                                        <p>{{  $dataTypeContent->price  }}</p>
                                </div>
                                <hr style="margin:0;">

                                <div class="panel-heading" style="border-bottom:0;">
                                        <h3 class="panel-title">Image</h3>
                                    </div>
            
                                    <div class="panel-body" style="padding-top:0;">
                                    @if($dataTypeContent->image && file_exists('storage/products'.$dataTypeContent->image))
                                    <img class="img-responsive" src="{{ asset('storage/products'. $dataTypeContent->image) }}">
                                    @else
                                    No image found
                                    @endif  
                                    </div>
                                    <hr style="margin:0;">

                                    <div class="panel-heading" style="border-bottom:0;">
                                            <h3 class="panel-title">Categories</h3>
                                        </div>
                
                                        <div class="panel-body" style="padding-top:0;">
                                        @forelse ($dataTypeContent->categories as $cat)
                                        <i class="{{ $cat->icon }}"></i>  {{ $cat->name }}  <br/>     
                                            @empty
                                                No category found!
                                        @endforelse
                                        </div>
                                        <hr style="margin:0;">

                </div>
            </div>
        </div>
    </div>

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.'.$dataType->slug.'.index') }}" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="{{ __('voyager::generic.delete_confirm') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('javascript')
    @if ($isModelTranslatable)
        <script>
            $(document).ready(function () {
                $('.side-body').multilingual();
            });
        </script>
    @endif
    <script>
        var deleteFormAction;
        $('.delete').on('click', function (e) {
            var form = $('#delete_form')[0];

            if (!deleteFormAction) {
                // Save form action initial value
                deleteFormAction = form.action;
            }

            form.action = deleteFormAction.match(/\/[0-9]+$/)
                ? deleteFormAction.replace(/([0-9]+$)/, $(this).data('id'))
                : deleteFormAction + '/' + $(this).data('id');

            $('#delete_modal').modal('show');
        });

    </script>
@stop

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">

@stop