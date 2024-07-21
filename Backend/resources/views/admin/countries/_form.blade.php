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
                                {{ __('Countries') }}
                            </legend>
                            <div class="collapse show" id="general">
                                <div class="form-group row">
                                    <label for="image" class="col-lg-2 col-form-label text-right"> <span class="text-danger">*</span>{{ __("Quốc Kỳ") }} :</label>
                                    <div class="col-lg-9">
                                        <div id="thumbnail">
                                            <div class="single-image clearfix">
                                                <div class="image-holder" onclick="document.getElementById('image').click();">
                                                    @if ($country->flag)
                                                        <img id="image_url"
                                                            src="{{ $country->flag}}"
                                                        />
                                                    @else
                                                        <img id="image_url"
                                                            src="{{ $country->getFirstMediaUrl('country') ?? '/backend/global_assets/images/placeholders/placeholder.jpg'}}"
                                                        />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <input type="file" name="image" id="image"
                                               class="form-control inputfile hide"
                                               onchange="document.getElementById('image_url').src = window.URL.createObjectURL(this.files[0])"
                                               accept="image/*"
                                        >
                                        @error('image')
                                            <span class="form-text text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <x-text-field
                                    name="name"
                                    :placeholder="__('Tên')"
                                    :label="__('Tên')"
                                    :value="$country->name"
                                    required
                                >
                                </x-text-field>
                                <x-text-field
                                    name="code"
                                    :placeholder="__('Mã Quốc Gia')"
                                    :label="__('Mã Quốc Gia')"
                                    :value="$country->code"
                                    required
                                >
                                </x-text-field>
                            </div>
                        </fieldset>

                    </x-card>
                    <div class="d-flex justify-content-center align-items-center action" id="action-form">
                        <a href="{{ route('admin.api.countries') }}" class="btn btn-light">{{ __('Trở lại') }}</a>
                        <div class="btn-group ml-3">
                            <button class="btn btn-primary btn-block" data-loading>{{ __('Lưu') }}</button>
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="javascript:void(0)" class="dropdown-item submit-type" data-redirect="{{ route('admin.api.countries') }}">{{ __('Lưu và thoát') }}</a>
                                <a href="javascript:void(0)" class="dropdown-item submit-type" data-redirect="{{ route('admin.banners.create') }}">{{ __('Lưu và tạo mới') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /left content -->
    </div>
</form>
