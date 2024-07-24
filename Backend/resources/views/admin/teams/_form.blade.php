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
                                @if($team->id)
                                    Cập nhật thông tin đội tuyển: {{ $team->name }}
                                @else
                                    Thêm mới đội tuyển
                                @endif
                            </legend>
                            <div class="collapse show" id="general">
                                <div class="form-group row">
                                    <label for="image" class="col-lg-2 col-form-label text-right"> <span class="text-danger">*</span>{{ __("Quốc Kỳ") }} :</label>
                                    <div class="col-lg-9">
                                        <div id="thumbnail">
                                            <div class="single-image clearfix">
                                                <div class="image-holder" onclick="document.getElementById('image').click();">
                                                    @if ($team->getFirstMediaUrl('country'))
                                                        <img id="image_url" src="{{ $team->getFirstMediaUrl('country') ?? '/backend/global_assets/images/placeholders/placeholder.jpg'}}" />
                                                    @else
                                                        <img id="image_url" src="{{ $team->logo }}" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <input type="file" name="flag" id="image" class="form-control inputfile hide" onchange="document.getElementById('image_url').src = window.URL.createObjectURL(this.files[0])" accept="image/*" >
                                        @error('image')
                                            <span class="form-text text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <x-text-field name="code" :placeholder="__('Mã đội tuyển')" :label="__('Mã đội tuyển')" :value="$team->code" required > </x-text-field>
                                <x-text-field name="slug" :label="__('Đường dẫn')" type="text" :value="$team->slug" :placeholder="__('Đường dẫn sẽ hiển thị trên URL của trang web')" > </x-text-field>
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label text-lg-right" for="">
                                        Là đội tuyển quốc gia:
                                    </label>
                                    <div class="col-lg-9">
                                        <div class="form-group form-check">
                                            <input id="nationalInput" type="hidden" name="national" value="{{$team->national}}">
                                            <input id="nationalCheckbox" type="checkbox" name="national" value="{{$team->national}}" class="form-check-input" {{ $team->national == 1 ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col">
                                        <x-text-field name="name" :placeholder="__('Tên tiếng anh')" :label="__('Tên tiếng anh')" :value="$team->name" required> </x-text-field>
                                    </div>
                                    <div class="col">
                                        <x-text-field name="name_vi" :placeholder="__('Tên tiếng việt')" :label="__('Tên tiếng việt')" :value="$team->name_vi" required> </x-text-field>
                                    </div>
                                </div>
                                <h5>{{ __('SEO') }}</h5>
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                      <a class="nav-link active" aria-current="page" data-toggle="tab" href="#en">Tiếng Anh</a>
                                    </li>
                                    <li class="nav-item">
                                      <a class="nav-link"  data-toggle="tab" href="#vi">Tiếng Việt</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="en" class="tab-pane fade in active show">
                                        <x-text-field name="meta_title" :label="__('Tiêu đề')" type="text" :value="$team->meta_title" :placeholder="__('Tiêu đề nên nhập từ 10 đến 70 ký tự trở lên')" > </x-text-field>

                                        <x-text-field name="meta_description" :label="__('Mô tả')" type="text" :value="$team->meta_description" :placeholder="__('Mô tả nên nhập từ 160 đến 255 ký tự trở lên')" > </x-text-field>

                                        <x-text-field name="meta_keywords" :label="__('Từ khóa')" type="text" :value="$team->meta_keywords" :placeholder="__('Từ khóa nên nhập 12 ký tự trong 1 từ khóa, cách nhau bằng dấu \',\'')" > </x-text-field>
                                    </div>
                                    <div id="vi" class="tab-pane">
                                        <x-text-field name="meta_title_vi" :label="__('Tiêu đề')" type="text" :value="$team->meta_title" :placeholder="__('Tiêu đề nên nhập từ 10 đến 70 ký tự trở lên')" > </x-text-field>

                                        <x-text-field name="meta_description_vi" :label="__('Mô tả')" type="text" :value="$team->meta_description" :placeholder="__('Mô tả nên nhập từ 160 đến 255 ký tự trở lên')" > </x-text-field>

                                        <x-text-field name="meta_keywords_vi" :label="__('Từ khóa')" type="text" :value="$team->meta_keywords" :placeholder="__('Từ khóa nên nhập 12 ký tự trong 1 từ khóa, cách nhau bằng dấu \',\'')" > </x-text-field>
                                    </div>
                                </div>
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
