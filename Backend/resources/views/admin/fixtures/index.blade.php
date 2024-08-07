@extends('admin.layouts.master')

@section('title', __('Danh sách các trận đấu trận đấu'))
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
        #league_filter{
            width: max-content;
        }
    </style>
@endpush

@section('page-content')
    <x-card>
        <label for="league_filter" id="custom_filter">
            <span>Giải đấu:</span>
            <form method="get" action="" id="filter_form" style="width: 300px;">
                <select id="league_filter" name="league" class="form-control">
                    <option value="">Tất cả</option>
                    @foreach($leagues as $league)
                    <option @if($league->api_id == $league_selected) selected @endif value="{{$league->api_id}}">{{$league->name}} - {{$league->country_name}}</option>
                    @endforeach
                </select>
            </form>
        </label>
        {{$dataTable->table()}}
    </x-card>

@stop

@push('js')
    {{$dataTable->scripts()}}
    <script>
        $('#league_filter').on('change', function(){
            $('#filter_form').submit();
        });
        $('#FixtureDataTable_filter').append($('#custom_filter'));
        $('#league_filter').select2();
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
