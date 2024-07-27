@php
    use Carbon\Carbon;
@endphp
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
                                @if(isset($fixture) && $fixture->id)
                                    Cập nhật thông tin trận đấu: {{ $fixture->name }}
                                @else
                                    Thêm mới trận đấu
                                @endif
                            </legend>
                            <div class="collapse show" id="general">
                                <x-text-field name="api_id" :placeholder="__('Mã trận')" :label="__('Mã trận')" :value="isset($fixture) ? $fixture->api_id : ''" :readonly="true" > </x-text-field>
                                <x-text-field name="referee" :placeholder="__('Trọng tài')" :label="__('Trọng tài')" :value="isset($fixture) ? $fixture->referee : ''" > </x-text-field>
                                <x-text-field name="date" :placeholder="__('Bắt đầu')" :label="__('Bắt đầu')" :value="isset($fixture) ? $fixture->date : ''" > </x-text-field>
                                <x-text-field name="round_1" :placeholder="__('Hiệp 1')" :label="__('Hiệp 1')" :value="(isset($fixture) && json_decode($fixture->periods)->first != null) ? Carbon::createFromTimeStamp(json_decode($fixture->periods)->first)->format('Y-m-d H:i:s') : ''" > </x-text-field>
                                <x-text-field name="round_2" :placeholder="__('Hiệp 2')" :label="__('Hiệp 2')" :value="(isset($fixture) && json_decode($fixture->periods)->second != null) ? Carbon::createFromTimeStamp(json_decode($fixture->periods)->second)->format('Y-m-d H:i:s') : ''" > </x-text-field>
                                <x-text-field name="venue_id" :placeholder="__('ID sân')" :label="__('ID sân')" :value="isset($fixture) ? json_decode($fixture->venue)->id  : ''" :readonly='true'> </x-text-field>
                                <x-text-field name="league_id" :placeholder="__('ID giải')" :label="__('ID giải')" :value="isset($fixture) ? json_decode($fixture->league)->id  : ''" :readonly='true'> </x-text-field>
                                <x-text-field name="team_home" :placeholder="__('Đội nhà')" :label="__('Đội nhà')" :value="isset($fixture) ? json_decode($fixture->teams)->home->name : ''" :readonly="true"> </x-text-field>
                                <x-text-field name="team_away" :placeholder="__('Đội Khách')" :label="__('Đội Khách')" :value="isset($fixture) ? json_decode($fixture->teams)->away->name : ''" :readonly="true"> </x-text-field>
                                <x-text-field name="goals_home" :placeholder="__('Bàn thắng đội nhà')" :label="__('Bàn thắng đội nhà')" :value="isset($fixture) ? json_decode($fixture->goals)->home : ''" > </x-text-field>
                                <x-text-field name="goals_away" :placeholder="__('Bàn thắng đội khách')" :label="__('Bàn thắng đội khách')" :value="isset($fixture) ? json_decode($fixture->goals)->away : ''" > </x-text-field>
                                <x-text-field name="slug" :label="__('Đường dẫn')" type="text" :value="isset($fixture) ? $fixture->slug : ''" :placeholder="__('Đường dẫn sẽ hiển thị trên URL của trang web')" > </x-text-field>
                                <div class="form-group row">
                                    <label for="select-taxon" class="col-lg-2 text-lg-right col-form-label">
                                        <span class="text-danger">*</span> {{ __('Bài viết liên quan') }}
                                    </label>
                                    <div class="col-lg-9" id="select2">
                                        <select name="related_posts[]" class="form-control select2" data-width="100%"
                                                multiple>
                                            <option value="">
                                                {{ __('Chọn bài viết') }}
                                            </option>
                                            @foreach($posts as $post)
                                                <option value="{{ $post->id }}"
                                                        @if(in_array($post->id, $posts->pluck('id')->toArray())) selected @endif>
                                                    {{ $post->title_vi ?? $post->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="clearfix"></div>
                                        @error('category')
                                            <span class="form-text text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col">
                                        <x-text-field name="name" :placeholder="__('Tên tiếng anh')" :label="__('Tên tiếng anh')" :value="isset($fixture) ? $fixture->name : ''" required> </x-text-field>
                                    </div>
                                    <div class="col">
                                        <x-text-field name="name_vi" :placeholder="__('Tên tiếng việt')" :label="__('Tên tiếng việt')" :value="isset($fixture) ? $fixture->name_vi : ''" required> </x-text-field>
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
                                        <x-textarea-field name="content" :label="__('Nội dung')" :value="isset($fixture) ? $fixture->content : ''" :placeholder="__('Nội dung')" > </x-textarea-field>

                                        <x-text-field name="meta_title" :label="__('Tiêu đề')" type="text" :value="isset($fixture) ? $fixture->meta_title : ''" :placeholder="__('Tiêu đề nên nhập từ 10 đến 70 ký tự trở lên')" > </x-text-field>

                                        <x-text-field name="meta_description" :label="__('Mô tả')" type="text" :value="isset($fixture) ? $fixture->meta_description : ''" :placeholder="__('Mô tả nên nhập từ 160 đến 255 ký tự trở lên')" > </x-text-field>

                                        <x-text-field name="meta_keywords" :label="__('Từ khóa')" type="text" :value="isset($fixture) ? $fixture->meta_keywords : ''" :placeholder="__('Từ khóa nên nhập 12 ký tự trong 1 từ khóa, cách nhau bằng dấu \',\'')" > </x-text-field>
                                    </div>
                                    <div id="vi" class="tab-pane">
                                        <x-textarea-field name="vi_content" :label="__('Nội dung')" :value="isset($fixture) ? $fixture->vi_content : ''" :placeholder="__('Nội dung')" > </x-textarea-field>

                                        <x-text-field name="meta_title_vi" :label="__('Tiêu đề')" type="text" :value="isset($fixture) ? $fixture->meta_title : ''" :placeholder="__('Tiêu đề nên nhập từ 10 đến 70 ký tự trở lên')" > </x-text-field>

                                        <x-text-field name="meta_description_vi" :label="__('Mô tả')" type="text" :value="isset($fixture) ? $fixture->meta_description : ''" :placeholder="__('Mô tả nên nhập từ 160 đến 255 ký tự trở lên')" > </x-text-field>

                                        <x-text-field name="meta_keywords_vi" :label="__('Từ khóa')" type="text" :value="isset($fixture) ? $fixture->meta_keywords : ''" :placeholder="__('Từ khóa nên nhập 12 ký tự trong 1 từ khóa, cách nhau bằng dấu \',\'')" > </x-text-field>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                    </x-card>
                    <div class="d-flex justify-content-center align-items-center action" id="action-form">
                        <a href="{{ route('admin.api.fixtures') }}" class="btn btn-light">{{ __('Trở lại') }}</a>
                        <div class="btn-group ml-3">
                            <button class="btn btn-primary btn-block" data-loading>{{ __('Lưu') }}</button>
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="javascript:void(0)" class="dropdown-item submit-type" data-redirect="{{ route('admin.api.fixtures') }}">{{ __('Lưu và thoát') }}</a>
                                <a href="javascript:void(0)" class="dropdown-item submit-type" data-redirect="{{ route('admin.api.fixtures') }}">{{ __('Lưu và tạo mới') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /left content -->
    </div>
</form>
