@extends('admin.layouts.master')

@section('title', __('Chỉnh sửa :model', ['model' => $fixture->name]))
@section('page-header')
    {{-- <x-page-header>
        {{ Breadcrumbs::render('admin.country.edit', $country) }}
    </x-page-header> --}}
@stop

@section('page-content')
    @include('admin.fixtures._form', [
        'url' =>  route('admin.api.fixture.update', $fixture),
        'method' => 'PUT'
    ])
@stop

@push('js')
    <script>
        $('.form-check-input-styled').uniform();
        
        $('#injuredCheckbox').on('change', function() {
            if ($(this).is(':checked')) {
                $('#injuredInput').val(1);
            } else {
                $('#injuredInput').val(0);
            }
        })
    </script>
    {{-- {!! JsValidator::formRequest('App\Http\Requests\Admin\CountryUpdateRequest', '#country-form'); !!} --}}
@endpush
