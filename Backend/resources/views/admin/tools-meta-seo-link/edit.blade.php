@extends('admin.layouts.master')

@section('title', __('Chỉnh sửa :model', ['model' => $tool->name]))
@section('page-header')
    {{-- <x-page-header>
        {{ Breadcrumbs::render('admin.country.edit', $country) }}
    </x-page-header> --}}
@stop

@section('page-content')
    @include('admin.tools-meta-seo-link._form', [
        'url' =>  route('admin.api.tools-meta-seo-link.update', $tool),
        'method' => 'PUT'
    ])
@stop

@push('js')
    <script>
        $('.form-check-input-styled').uniform();
        
        $('#nationalCheckbox').on('change', function() {
            if ($(this).is(':checked')) {
                $('#nationalInput').val(1);
            } else {
                $('#nationalInput').val(0);
            }
        })
    </script>
    {{-- {!! JsValidator::formRequest('App\Http\Requests\Admin\CountryUpdateRequest', '#country-form'); !!} --}}
@endpush
