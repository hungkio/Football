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
                                    Thông tin tool meta seo link: {{ $tool->name }}
                                @else
                                    Thêm mới tool meta seo link
                                @endif
                            </legend>
                            <div class="collapse show" id="general">
                                <x-text-field required name="origin_link" :placeholder="__('Đường dẫn gốc')" :label="__('Đường dẫn gốc')" :value="isset($tool) ? $tool->origin_link : ''" required > </x-text-field>
                                <x-text-field required name="meta_canonical" :label="__('Đường dẫn điều hướng')" type="text" :value="isset($tool) ? $tool->redirect_link : ''" :placeholder="__('Đường dẫn điều hướng')" > </x-text-field>
                            </div>
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
                                    <x-textarea-field name="name_vi" :label="__('Tên')" :value="isset($player) ? $player->content : ''" :placeholder="__('Tên')" > </x-textarea-field>
                                    <x-text-field name="meta_title_vi" :label="__('Tiêu đề')" type="text" :value="isset($player) ? $player->meta_title : ''" :placeholder="__('Tiêu đề nên nhập từ 10 đến 70 ký tự trở lên')" > </x-text-field>

                                    <x-text-field name="meta_keyword_vi" :label="__('Từ khóa')" type="text" :value="isset($player) ? $player->meta_description : ''" :placeholder="__('Từ khóa')" > </x-text-field>

                                    <x-text-field name="meta_description_vi" :label="__('Mô tả')" type="text" :value="isset($player) ? $player->meta_keywords : ''" :placeholder="__('Mô tả')" > </x-text-field>
                                    <x-text-field name="content_header_vi" :label="__('Tiêu đề nội dung')" type="text" :value="isset($player) ? $player->meta_keywords : ''" :placeholder="__('Tiêu đề nội dung') "> </x-text-field>
                                    <x-text-field name="content_footer_vi" :label="__('Nội dung chân trang')" type="text" :value="isset($player) ? $player->meta_keywords : ''" :placeholder="__('Nội dung chân trang')" > </x-text-field>
                                </div>
                                <div id="vi" class="tab-pane">
                                    <x-textarea-field name="name_en" :label="__('Tên')" :value="isset($player) ? $player->content_vi : ''" :placeholder="__('Tên')" > </x-textarea-field>
                                    <x-text-field name="meta_title_en" :label="__('Tiêu đề')" type="text" :value="isset($player) ? $player->meta_title : ''" :placeholder="__('Tiêu đề nên nhập từ 10 đến 70 ký tự trở lên')" > </x-text-field>

                                    <x-text-field name="meta_keyword_en" :label="__('Từ khóa')" type="text" :value="isset($player) ? $player->meta_description : ''" :placeholder="__('Từ khóa')" > </x-text-field>

                                    <x-text-field name="meta_description_en" :label="__('Tiêu đề nội dung')" type="text" :value="isset($player) ? $player->meta_keywords : ''" :placeholder="__('Mô tả') "> </x-text-field>

                                    <x-text-field name="content_header_vi" :label="__('Tiêu đề nội dung')" type="text" :value="isset($player) ? $player->meta_keywords : ''" :placeholder="__('Tiêu đề nội dung') "> </x-text-field>

                                    <x-text-field name="content_footer_en" :label="__('Nội dung chân trang')" type="text" :value="isset($player) ? $player->meta_keywords : ''" :placeholder="__('Nội dung chân trang')" > </x-text-field>
                                </div>
                            </div>
                        </fieldset>

                    </x-card>
                    <div class="d-flex justify-content-center align-items-center action" id="action-form">
                        <a href="{{ route('admin.tools-meta-seo-link') }}" class="btn btn-light">{{ __('Trở lại') }}</a>
                        <div class="btn-group ml-3">
                            <button class="btn btn-primary btn-block" data-loading>{{ __('Lưu') }}</button>
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="javascript:void(0)" class="dropdown-item submit-type" data-redirect="{{ route('admin.tools-meta-seo-link') }}">{{ __('Lưu và thoát') }}</a>
                                <a href="javascript:void(0)" class="dropdown-item submit-type" data-redirect="{{ route('admin.api.tools-meta-seo-link.create') }}">{{ __('Lưu và tạo mới') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /left content -->
    </div>
</form>
