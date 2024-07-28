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
                                @if(isset($coach) && $coach->id)
                                    Cập nhật thông tin HLV: {{ $coach->name }}
                                @else
                                    Thêm mới HLV
                                @endif
                            </legend>
                            <div class="collapse show" id="general">
                                <div class="form-group row">
                                    <label for="image" class="col-lg-2 col-form-label text-right"> <span class="text-danger">*</span>{{ __("Ảnh") }} :</label>
                                    <div class="col-lg-9">
                                        <div id="thumbnail">
                                            <div class="single-image clearfix">
                                                <div class="image-holder" onclick="document.getElementById('image').click();">
                                                    @if (isset($coach) && $coach->getFirstMediaUrl('coach'))
                                                        <img id="image_url" src="{{ $coach->getFirstMediaUrl('coach') ?? '/backend/global_assets/images/placeholders/placeholder.jpg'}}" />
                                                    @elseif(isset($coach) && !$coach->getFirstMediaUrl('coach'))
                                                        <img id="image_url" src="{{ $coach->photo }}" />
                                                    @else
                                                        <img id="image_url" src="/backend/global_assets/images/placeholders/placeholder.jpg" />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <input type="file" name="photo" id="image" class="form-control inputfile hide" onchange="document.getElementById('image_url').src = window.URL.createObjectURL(this.files[0])" accept="image/*" >
                                        @error('image')
                                            <span class="form-text text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <x-text-field name="api_id" :placeholder="__('Mã số')" :label="__('Mã số')" :value="isset($coach) ? $coach->api_id : ''" required > </x-text-field>
                                <x-text-field name="name" :placeholder="__('Tên đầy đủ')" :label="__('Tên đầy đủ')" :value="isset($coach) ? $coach->name : ''" > </x-text-field>
                                <x-text-field name="firstname" :placeholder="__('Tên')" :label="__('Tên')" :value="isset($coach) ? $coach->first_name : ''" > </x-text-field>
                                <x-text-field name="lastname" :placeholder="__('Họ')" :label="__('Họ')" :value="isset($coach) ? $coach->last_name : ''" > </x-text-field>
                                <x-text-field name="age" :placeholder="__('Tuổi')" :label="__('Tuổi')" :value="isset($coach) ? $coach->age : ''" > </x-text-field>
                                <x-text-field name="date_of_birth" :placeholder="__('Ngày sinh')" :label="__('Ngày sinh')" :value="isset($coach) ? $coach->date_of_birth : ''" > </x-text-field>
                                <x-text-field name="place_of_birth" :placeholder="__('Nơi sinh')" :label="__('Nơi sinh')" :value="isset($coach) ? $coach->place_of_birth : ''" > </x-text-field>
                                <x-text-field name="country" :placeholder="__('Quốc gia')" :label="__('Quốc gia')" :value="isset($coach) ? $coach->country : ''" > </x-text-field>
                                <x-text-field name="nationality" :placeholder="__('Quốc tịch')" :label="__('Quốc tịch')" :value="isset($coach) ? $coach->nationality : ''" > </x-text-field>
                                <x-text-field name="height" :placeholder="__('Chiều cao')" :label="__('Chiều cao')" :value="isset($coach) ? $coach->height : ''" > </x-text-field>
                                <x-text-field name="weight" :placeholder="__('Cân nặng')" :label="__('Cân nặng')" :value="isset($coach) ? $coach->weight : ''" > </x-text-field>
                                <x-text-field name="slug" :label="__('Đường dẫn')" type="text" :value="isset($coach) ? $coach->slug : ''" :placeholder="__('Đường dẫn sẽ hiển thị trên URL của trang web')" > </x-text-field>
                                <x-text-field name="team_id" :label="__('ID đội bóng')" type="text" :value="isset($coach) ? $coach->team_id : ''" :placeholder="__('ID đội bóng sẽ hiển thị trên URL của trang web')" > </x-text-field>
                                
                                {{-- <div class="row">
                                    <div class="col">
                                        <x-text-field name="name" :placeholder="__('Tên tiếng anh')" :label="__('Tên tiếng anh')" :value="isset($coach) ? $coach->name : ''" required> </x-text-field>
                                    </div>
                                    <div class="col">
                                        <x-text-field name="name_vi" :placeholder="__('Tên tiếng việt')" :label="__('Tên tiếng việt')" :value="isset($coach) ? $coach->name_vi : ''" required> </x-text-field>
                                    </div>
                                </div> --}}
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
                                        <x-textarea-field name="content" :label="__('Nội dung')" :value="isset($coach) ? $coach->content : ''" :placeholder="__('Nội dung')" > </x-textarea-field>
                                        <x-text-field name="meta_title" :label="__('Tiêu đề')" type="text" :value="isset($coach) ? $coach->meta_title : ''" :placeholder="__('Tiêu đề nên nhập từ 10 đến 70 ký tự trở lên')" > </x-text-field>

                                        <x-text-field name="meta_description" :label="__('Mô tả')" type="text" :value="isset($coach) ? $coach->meta_description : ''" :placeholder="__('Mô tả nên nhập từ 160 đến 255 ký tự trở lên')" > </x-text-field>

                                        <x-text-field name="meta_keywords" :label="__('Từ khóa')" type="text" :value="isset($coach) ? $coach->meta_keywords : ''" :placeholder="__('Từ khóa nên nhập 12 ký tự trong 1 từ khóa, cách nhau bằng dấu \',\'')" > </x-text-field>
                                    </div>
                                    <div id="vi" class="tab-pane">
                                        <x-textarea-field name="content_vi" :label="__('Nội dung')" :value="isset($coach) ? $coach->content_vi : ''" :placeholder="__('Nội dung')" > </x-textarea-field>
                                        <x-text-field name="meta_title_vi" :label="__('Tiêu đề')" type="text" :value="isset($coach) ? $coach->meta_title : ''" :placeholder="__('Tiêu đề nên nhập từ 10 đến 70 ký tự trở lên')" > </x-text-field>

                                        <x-text-field name="meta_description_vi" :label="__('Mô tả')" type="text" :value="isset($coach) ? $coach->meta_description : ''" :placeholder="__('Mô tả nên nhập từ 160 đến 255 ký tự trở lên')" > </x-text-field>

                                        <x-text-field name="meta_keywords_vi" :label="__('Từ khóa')" type="text" :value="isset($coach) ? $coach->meta_keywords : ''" :placeholder="__('Từ khóa nên nhập 12 ký tự trong 1 từ khóa, cách nhau bằng dấu \',\'')" > </x-text-field>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                    </x-card>
                    <div class="d-flex justify-content-center align-items-center action" id="action-form">
                        <a href="{{ route('admin.api.players') }}" class="btn btn-light">{{ __('Trở lại') }}</a>
                        <div class="btn-group ml-3">
                            <button class="btn btn-primary btn-block" data-loading>{{ __('Lưu') }}</button>
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="javascript:void(0)" class="dropdown-item submit-type" data-redirect="{{ route('admin.api.players') }}">{{ __('Lưu và thoát') }}</a>
                                <a href="javascript:void(0)" class="dropdown-item submit-type" data-redirect="{{ route('admin.api.players') }}">{{ __('Lưu và tạo mới') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /left content -->
    </div>
</form>
