@extends('admin.layouts.master')

@section('title', __('Giải đấu'))
{{-- @section('page-header')
    <x-page-header>
        {{ Breadcrumbs::render() }}
    </x-page-header>
@stop --}}

@push('css')
    <style>
        @media (max-width: 767.98px) {
            .btn-danger {
                margin-left: 0!important;
            }
        }
        @media (width: 320px) {
            .btn-danger {
                margin-left: .625rem!important;
            }
        }
        #custom_filter>*{
            display: inline-block;
        }
        #custom_filter{
            padding-left: 15px;
        }
        #country_code_filter{
            width: max-content;
        }
    </style>
@endpush

@section('page-content')
    <x-card>
        <label for="country_code_filter" id="custom_filter">
            <span>Quốc gia:</span>
            <form method="get" action="" id="filter_form">
                <select id="country_code_filter" name="country_code" class="form-control">
                    <option value="">All</option>
                    @foreach($countries as $country)
                    <option @if($country->code==$country_code) selected @endif value="{{$country->code}}">{{$country->name}}</option>
                    @endforeach
                </select>
            </form>
            </label>
        {{$dataTable->table()}}
    </x-card>

@stop

@push('js')
    <script>
        $('#country_code_filter').on('change', function(){
            $('#filter_form').submit();
        });
      (function ($, DataTable) {
            "use strict";

            DataTable.ext.buttons.save = {
                className: 'buttons-save',

                text: function (dt) {
                    return '<i class="fa fa-save"></i> ' + dt.i18n('buttons.save', 'Save');
                },

                action: function (e, dt, button, config) {
                    var data = $('.popular, .shown_standing, .priority').serialize();
                    $.each($('.popular')
                        .filter(function(idx){
                            return $(this).prop('checked') === false
                        }),
                        function(idx, el){
                            // attach matched element names to the formData with a chosen value.
                            var emptyVal = 0;
                            data += '&' + $(el).attr('name') + '=' + emptyVal;
                        }
                    );
                    $.each($('.shown_standing')
                        .filter(function(idx){
                            return $(this).prop('checked') === false
                        }),
                        function(idx, el){
                            // attach matched element names to the formData with a chosen value.
                            var emptyVal = 0;
                            data += '&' + $(el).attr('name') + '=' + emptyVal;
                        }
                    );
                    confirmAction('Bạn có muốn thực hiện những thay đổi này không ?', function (result) {
                        if (result) {
                            $.ajax({
                                url: '{{route('admin.api.league.savepsp')}}',
                                data: data,
                                type: 'POST',
                                dataType: 'json',
                                success: function(res) {
                                    if(res.status == true){
                                        showMessage('success', res.message);
                                    }else{
                                        showMessage('error', res.message);
                                    }
                                    window.LaravelDataTables['{{ $dataTable->getTableAttribute('id') }}'].ajax.reload();
                                },
                            });
                        }else{
                            window.LaravelDataTables['{{ $dataTable->getTableAttribute('id') }}'].ajax.reload();
                        }
                    });
                }
            };
        })(jQuery, jQuery.fn.dataTable);
    </script>
    {{$dataTable->scripts()}}
    <script>
        $('#LeagueDataTable_filter').append($('#custom_filter'));
        $(document).on('change','#select_status', function () {
            var status = $(this).val();
            var url = $(this).attr('data-url');
            confirmAction('Bạn có muốn thay đổi trạng thái ?', function (result) {
                if (result) {
                    $.ajax({
                        url: url,
                        data: {
                            'status': status
                        },
                        type: 'POST',
                        dataType: 'json',
                        success: function(res) {
                            if(res.status == true){
                                showMessage('success', res.message);
                            }else{
                                showMessage('error', res.message);
                            }
                            window.LaravelDataTables['{{ $dataTable->getTableAttribute('id') }}'].ajax.reload();
                        },
                    });
                }else{
                    window.LaravelDataTables['{{ $dataTable->getTableAttribute('id') }}'].ajax.reload();
                }
            });
        });
        @can('posts.create')
        $('.buttons-create').removeClass('d-none')
        @endcan
        @can('posts.delete')
        $('.btn-danger').removeClass('d-none')
        @endcan
        @can('posts.update')
        $('.btn-warning').removeClass('d-none')
        @endcan

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endpush
