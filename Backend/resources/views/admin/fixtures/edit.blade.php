@extends('admin.layouts.master')

@section('title', __('Chỉnh sửa :model', ['model' => $player->name]))
@section('page-header')
    {{-- <x-page-header>
        {{ Breadcrumbs::render('admin.country.edit', $country) }}
    </x-page-header> --}}
@stop

@section('page-content')
    @include('admin.players._form', [
        'url' =>  route('admin.api.player.update', $player),
        'banner' => $player ?? new \App\Domain\Team\Models\Team,
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
