@extends('admin.layouts.master')

@section('title', __('Chỉnh sửa :model', ['model' => $coach->name]))
@section('page-header')
    {{-- <x-page-header>
        {{ Breadcrumbs::render('admin.country.edit', $country) }}
    </x-page-header> --}}
@stop

@section('page-content')
    @include('admin.coaches._form', [
        'url' =>  route('admin.api.coach.update', $coach),
        'banner' => $coach ?? new \App\Domain\Coach\Models\Coach,
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
