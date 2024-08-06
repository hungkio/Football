<form action="{{ $url }}" method="POST" data-block enctype="multipart/form-data" id="country-form">
    @csrf
    @method($method ?? 'POST')
    <div class="d-flex align-items-start flex-column flex-md-row">
        <!-- Left content -->
        <div class="w-100 order-2 order-md-1 left-content">
            <div class="row">
                <div class="col-md-12">
                    <x-card>
                        <fieldset>
                            <legend class="font-weight-semibold text-uppercase font-size-sm">
                                @if(isset($tool) && $tool->id)
                                    Thông tin tool redirecter: {{ $tool->name }}
                                @else
                                    Thêm mới tool redirecter
                                @endif
                            </legend>
                            <div class="collapse show" id="general">
                                <x-text-field required name="origin_link" :placeholder="__('Đường dẫn gốc')" :label="__('Đường dẫn gốc')" :value="isset($tool) ? $tool->origin_link : ''" required > </x-text-field>
                                <x-text-field required name="redirect_link" :label="__('Đường dẫn điều hướng')" type="text" :value="isset($tool) ? $tool->redirect_link : ''" :placeholder="__('Đường dẫn điều hướng')" > </x-text-field>
                                <x-text-field required name="start_at" :placeholder="__('Ngày bắt đầu')" :label="__('Ngày bắt đầu')" :value="isset($tool) ? $tool->start_at : ''" required > </x-text-field>
                                <x-text-field required name="end_at" :label="__('Ngày kết thúc')" type="text" :value="isset($tool) ? $tool->end_at : ''" :placeholder="__('Ngày kết thúc')" > </x-text-field>
                            </div>
                        </fieldset>

                    </x-card>
                    <div class="d-flex justify-content-center align-items-center action" id="action-form">
                        <a href="{{ route('admin.api.countries') }}" class="btn btn-light">{{ __('Trở lại') }}</a>
                        <div class="btn-group ml-3">
                            <button class="btn btn-primary btn-block" data-loading>{{ __('Lưu') }}</button>
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="javascript:void(0)" class="dropdown-item submit-type" data-redirect="{{ route('admin.api.tools-redirecter') }}">{{ __('Lưu và thoát') }}</a>
                                <a href="javascript:void(0)" class="dropdown-item submit-type" data-redirect="{{ route('admin.api.tools-redirecter.create') }}">{{ __('Lưu và tạo mới') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /left content -->
    </div>
</form>
