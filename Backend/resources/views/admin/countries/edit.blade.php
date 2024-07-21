@extends('admin.layouts.master')

@section('title', __('Chỉnh sửa :model', ['model' => $country->name]))
@section('page-header')
    {{-- <x-page-header>
        {{ Breadcrumbs::render('admin.country.edit', $country) }}
    </x-page-header> --}}
@stop

@section('page-content')
    @include('admin.countries._form', [
        'url' =>  route('admin.api.countries.update', $country),
        'banner' => $country ?? new \App\Domain\Country\Models\Country,
        'method' => 'PUT'
    ])
@stop

@push('js')
    <script>
        $('.form-check-input-styled').uniform();
    </script>
    {{-- {!! JsValidator::formRequest('App\Http\Requests\Admin\CountryUpdateRequest', '#country-form'); !!} --}}
@endpush
