@extends('admin.layouts.master')

@section('title', __('Chỉnh sửa'))

@section('page-header')
    {{-- <x-page-header>
        {{ Breadcrumbs::render() }}
    </x-page-header> --}}
@stop
@push('css')
    <link rel="stylesheet" href="{{ asset('backend/global_assets/js/plugins/jstree/themes/default/style.min.css') }}">
    <style>
        .icon-md {
            font-size: 1.5rem;
        }

        select.form-control {
            -moz-appearance: none;
            -webkit-appearance: none;
            appearance: none;
        }

        label.error {
            color: red;
        }
    </style>
@endpush

@push('js')

@endpush
@section('page-content')
    <!-- Inner container -->
    <form action="{{route('admin.internal-links.save')}}" method="POST">
        @csrf
        <div class="d-flex align-items-start flex-column flex-md-row">
            <!-- Left content -->
            <div class="w-100 order-2 order-md-1 left-content">

                <div class="row">
                    <div class="col-md-12">
                        <x-card>
                            <fieldset>
                                <legend class="font-weight-semibold text-uppercase font-size-sm">
                                    {{ __('Chung') }}
                                </legend>

                                <input type="hidden" name="id" value="{{$id}}">
                                <div class="collapse show" id="general">
                                    <x-text-field
                                        name="url"
                                        :label="__('URL')"
                                        :value="$internalLink->url"
                                        required
                                    >
                                    </x-text-field>
                                </div>
                            </fieldset>
                        </x-card>
                        <div class="d-flex justify-content-center align-items-center action" id="action-form">
                            <a href="{{ route('admin.internal-links') }}" class="btn btn-light"><i
                                    class="fal fa-arrow-left mr-2"></i>{{ __('Trở lại') }}</a>
                            <div class="btn-group ml-3">
                                <button class="btn btn-primary btn-block" data-loading><i
                                        class="fal fa-check mr-2"></i>{{ __('Lưu') }}</button>
                                <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"></button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="javascript:void(0)" class="dropdown-item submit-type"
                                       data-redirect="{{ route('admin.menus.index') }}">{{ __('Lưu và thoát') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /left content -->
        </div>
        <!-- /inner container -->
    </form>
@stop
