<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        @yield('title')
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}" id="csrf_token">
    <link rel="icon" href="{{ setting('store_favicon') ? \Storage::url(setting('store_favicon')) : '' }}" type="image/gif" sizes="16x16">

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('/backend/global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/backend/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/backend/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/backend/css/layout.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/backend/css/components.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/backend/css/colors.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/backend/css/theme.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/backend/fontawesome/css/all.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/backend/css/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    @stack('css')
</head>
<body class="@yield('body-class')" data-spy="scroll" data-target=".sidebar-component-right">
@yield('navbar')
@yield('content')
<script>
    window.Config = {
        dateFormat: 'd-m-Y H:i',
        baseUrl: '{{ url('/') }}',
        version: '{{ config('ecc.app_version') }}',
        adminPrefix: '/admin',
        csrf: '{{ csrf_token() }}'
    }

    window.Lang = {
        confirm_delete: "{{ __('Bạn có chắc chắn muốn xóa ?') }}",
        oh_no: "{{ __('Ôi không !') }}",
        system: "{{ __('Hệ thống') }}",
        success: "{{ __('Thành công !') }}",
        confirm: "{{ __('Xác nhận') }}",
        yes: "{{ __('Có') }}",
        no: "{{ __('Không') }}",
        create: "{{ __('Tạo') }}",
        rename: "{{ __('Đổi tên') }}",
        edit: "{{ __('Chỉnh sửa') }}",
        remove: "{{ __('Xóa') }}",
    }
</script>
<script src="{{ asset('/backend/global_assets/js/main/jquery.min.js') }}"></script>
<script src="{{ asset('/backend/global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/backend/global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
<script src="{{ asset('/backend/global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
@stack('vendor-js')
<script src="{{ asset('/backend/js/app.js') }}"></script>
<script src="{{ asset('/backend/js/custom.js') }}"></script>
<script src="{{ asset('/backend/js/bootstrap-tagsinput.js') }}"></script>
@stack('js')
<script>
    if($('.noidung').lenght>0){
        console.log('check');
        tinymce.init({
    selector: "textarea.noidung",
    plugins: [
        "image imagetool",
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image",
    file_picker_callback: function (callback, value, meta) {
        let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

        let type = 'image' === meta.filetype ? 'Images' : 'Files',
            url  = '/laravel-filemanager?editor=tinymce5&type=' + type;

        tinymce.activeEditor.windowManager.openUrl({
            url : url,
            title : 'Filemanager',
            width : x * 0.8,
            height : y * 0.8,
            onMessage: (api, message) => {
                callback(message.content);
            }
        });
    }
});
    }
</script>
</body>
</html>
