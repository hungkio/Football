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
                                @if(isset($league) && $league->id)
                                    Cập nhật thông tin giải đấu: {{ $league->name }}
                                @else
                                    Thêm mới giải đấu
                                @endif
                            </legend>
                            <div class="collapse show" id="general">
                                <div class="form-group row">
                                    <label for="image" class="col-lg-2 col-form-label text-right"> <span class="text-danger">*</span>{{ __("Logo") }} :</label>
                                    <div class="col-lg-9">
                                        <div id="thumbnail">
                                            <div class="single-image clearfix">
                                                <div class="image-holder" onclick="document.getElementById('image').click();">
                                                    @if (isset($league) && $league->getFirstMediaUrl('league'))
                                                        <img id="image_url" src="{{ $league->getFirstMediaUrl('league') ?? '/backend/global_assets/images/placeholders/placeholder.jpg'}}" />
                                                    @elseif(isset($league) && !$league->getFirstMediaUrl('league'))
                                                        <img id="image_url" src="{{ $league->logo }}" />
                                                    @else
                                                        <img id="image_url" src="/backend/global_assets/images/placeholders/placeholder.jpg" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <input type="file" name="logo" id="image" class="form-control inputfile hide" onchange="document.getElementById('image_url').src = window.URL.createObjectURL(this.files[0])" accept="image/*" >
                                        @error('image')
                                            <span class="form-text text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="type" class="col-lg-2 col-form-label text-right"> {{ __("Mã giải") }} :</label>
                                    <div class="col-lg-9">
                                        <input class="form-control" type="text" name="api_id" placeholder="Mã giải" value="{{isset($league) ? $league->api_id : ''}}" readonly>
                                    </div>
                                </div>
                                <x-text-field name="slug" :label="__('Đường dẫn')" type="text" :value="isset($league) ? $league->slug : ''" :placeholder="__('Đường dẫn sẽ hiển thị trên URL của trang web')" > </x-text-field>
                                <x-text-field name="name" :placeholder="__('Tên')" :label="__('Tên')" :value="isset($league) ? $league->name : ''" required> </x-text-field>
                                {{-- <x-text-field name="type" :placeholder="__('Phân loại')" :label="__('Phân loại')" :value="isset($league) ? $league->type : ''" required> </x-text-field> --}}
                                <div class="form-group row">
                                    <label for="type" class="col-lg-2 col-form-label text-right"> {{ __("Phân loại") }} :</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" name="type">
                                            <option>{{ __('Chọn phân loại') }}</option>
                                            <option value="league">{{ __('League') }}</option>
                                            <option value="cup" >{{ __('Cup') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="country_code" class="col-lg-2 col-form-label text-right"> {{ __("Mã quốc gia") }} :</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" name="country_code">
                                            <option>{{ __('Chọn mã quốc gia') }}</option>
                                            @foreach ($country_codes as $country_code)
                                                <option value="{{$country_code}}"
                                                @if(in_array($country_code, $country_codes)) selected @endif
                                                >{{$country_code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="shown_on_country_standing" class="col-lg-2 col-form-label text-right"> {{ __("Đang hiển thị trên BXH QG") }} :</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" name="shown_on_country_standing">
                                            <option value="0" @if (!$league->shown_on_country_standing)
                                                selected
                                            @endif>Không hiển thị trên BXH QG</option>
                                            <option value="1"@if ($league->shown_on_country_standing)
                                                selected
                                            @endif>Đang hiển thị trên BXH QG</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="popular" class="col-lg-2 col-form-label text-right"> {{ __("Được quan tâm") }} :</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" name="popular">
                                            <option value="0" @if (!$league->popular)
                                                selected
                                            @endif>Không</option>
                                            <option value="1"@if ($league->popular)
                                                selected
                                            @endif>Có</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <x-text-field name="country_code" :placeholder="__('Mã quốc gia')" :label="__('Mã quốc gia')" :value="isset($league) ? $league->country_code : ''" required> </x-text-field> --}}
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
                                        <x-textarea-field name="content" :label="__('Nội dung')" :value="isset($league) ? $league->content : ''" :placeholder="__('Nội dung')" > </x-textarea-field>
                                        <x-text-field name="meta_title" :label="__('Tiêu đề')" type="text" :value="isset($league) ? $league->meta_title : ''" :placeholder="__('Tiêu đề nên nhập từ 10 đến 70 ký tự trở lên')" > </x-text-field>

                                        <x-text-field name="meta_description" :label="__('Mô tả')" type="text" :value="isset($league) ? $league->meta_description : ''" :placeholder="__('Mô tả nên nhập từ 160 đến 255 ký tự trở lên')" > </x-text-field>

                                        <x-text-field name="meta_keywords" :label="__('Từ khóa')" type="text" :value="isset($league) ? $league->meta_keywords : ''" :placeholder="__('Từ khóa nên nhập 12 ký tự trong 1 từ khóa, cách nhau bằng dấu \',\'')" > </x-text-field>
                                    </div>
                                    <div id="vi" class="tab-pane">
                                        <x-textarea-field name="content_vi" :label="__('Nội dung')" :value="isset($league) ? $league->content_vi : ''" :placeholder="__('Nội dung')" > </x-textarea-field>
                                        <x-text-field name="meta_title_vi" :label="__('Tiêu đề')" type="text" :value="isset($league) ? $league->meta_title : ''" :placeholder="__('Tiêu đề nên nhập từ 10 đến 70 ký tự trở lên')" > </x-text-field>

                                        <x-text-field name="meta_description_vi" :label="__('Mô tả')" type="text" :value="isset($league) ? $league->meta_description : ''" :placeholder="__('Mô tả nên nhập từ 160 đến 255 ký tự trở lên')" > </x-text-field>

                                        <x-text-field name="meta_keywords_vi" :label="__('Từ khóa')" type="text" :value="isset($league) ? $league->meta_keywords : ''" :placeholder="__('Từ khóa nên nhập 12 ký tự trong 1 từ khóa, cách nhau bằng dấu \',\'')" > </x-text-field>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                    </x-card>
                    <div class="d-flex justify-content-center align-items-center action" id="action-form">
                        <a href="{{ route('admin.api.leagues') }}" class="btn btn-light">{{ __('Trở lại') }}</a>
                        <div class="btn-group ml-3">
                            <button class="btn btn-primary btn-block" data-loading>{{ __('Lưu') }}</button>
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="javascript:void(0)" class="dropdown-item submit-type" data-redirect="{{ route('admin.api.leagues') }}">{{ __('Lưu và thoát') }}</a>
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
