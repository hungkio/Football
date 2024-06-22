@extends('admin.layouts.master')

@section('title', __('Quản lý link nội tuyến'))
@section('page-header')
    <x-page-header>
        {{ Breadcrumbs::render() }}
    </x-page-header>
@stop

@push('css')
    <style>
        label.error {
            color: red;
        }
    </style>
@endpush

@section('page-content')
    <x-card>
        {{$dataTable->table()}}
    </x-card>
    <div class="modal fade" id="createInternalLink" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form class="modal-content" id="create-internal-link"
                  action="{{route('admin.internal-links.save')}}"
                  method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Tạo link nội tuyến') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">{{ __('URL') }}</label>
                        <div>
                            <input type="text" name="url" value="" id="name_menu" placeholder="{{ __('Nhập link nội tuyến...') }}"
                                   class="form-control ">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Đóng') }}</button>
                    <button type="submit" class="btn btn-primary save_menu">{{ __('Lưu') }}</button>
                </div>
            </form>
        </div>
    </div>
@stop

@push('js')
<script src="{{ asset('backend/global_assets/js/plugins/forms/styling/switchery.min.js') }}"></script>
{{$dataTable->scripts()}}
<script>
    $(function () {
        @cannot('menus.store')
        $('.buttons-create').remove()
        @endcan
        @cannot('menus.edit')
        $('.buttons-create').remove()
        @endcan
        @can('menus.delete')
        $('.bg-danger').removeClass('d-none')
        @endcan
        $('#create-menu').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255,
                }
            },
            messages: {
                name: {
                    required: "Hãy nhập tên menu",
                    maxlength: "Tên menu quá dài",
                }
            }
        })
        $('#create-menu').submit(function (e) {
            e.preventDefault();
            if ($('#create-menu').valid()) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: '{{ route('admin.menus.store') }}',
                    data: $('#create-menu').serialize()
                }).done(function (d) {
                    location.reload();
                }).fail(function (data) {
                    let msg = ''
                    if (data.message) {
                        msg = data.message
                    } else {
                        msg = data.responseJSON.errors.name[0]
                    }
                    showMessage('error', msg);
                });
            }
        })
    })
    $(document).on('change', '#select_status', function () {
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
                    success: function (res) {
                        if (res.status == true) {
                            showMessage('success', res.message);
                        } else {
                            showMessage('error', res.message);
                        }
                        window.LaravelDataTables['{{ $dataTable->getTableAttribute('id') }}'].ajax.reload();
                    },
                });
            } else {
                window.LaravelDataTables['{{ $dataTable->getTableAttribute('id') }}'].ajax.reload();
            }
        });
    });

    $('#createMenu').on('hidden.bs.modal', function () {
        // do something…
        $('#name_menu').val('')
        $('#name_menu-error').text('')
    })
</script>
@endpush
