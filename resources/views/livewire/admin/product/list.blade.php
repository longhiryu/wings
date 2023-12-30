<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <div class="row">
                    <div class="col-12 col-md-6">
                        {{ __('text.txt_product_list') }}
                    </div>
                    <div class="col-12 col-md-6 d-flex justify-content-end">
                        @if ($suppliers)
                            @include('livewire.admin.blocks.add_new_button', ['model' => $model])
                        @else
                            <span class="text-danger size_text">Bạn phải tạo "Nhà cung cấp trước khi Tạo sản phẩm"</span>
                        @endif

                    </div>
                </div>
            </h4>
            <p class="card-description">
                Danh sách hiển thị Sản phẩm bạn có thể chọn "Danh sách nhóm" hoặc nhập "từ khóa" vào ô tìm
                kiếm để lọc dữ liệu mà bạn cần.
            </p>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label>{{ __('text.category') }}</label>
                        <select class="form-control form-control-sm" wire:model="parent">
                            <option value="">{{ __('text.txt_default') }}</option>
                            @foreach ($cateTree as $category)
                                <option value="{{ $category['id'] }}">
                                    {{ str_repeat('--', $category['level']) }} {{ $category['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-8">
                        @include('livewire.admin.blocks.search_input')
                    </div>
                </div>
            </div>
            <div wire:loading wire:target="keyword" style="width: 100%">
                <div class="d-flex align-content-center justify-content-center"><i class="fa-solid fa-spinner fa-spin"></i></div> 
            </div>
            <div class="table-responsive">
                <table class="table-striped list table">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>{{ __('text.txt_status') }}</th>
                            <th>{{ __('text.category') }}</th>
                            <th>{{ __('text.txt_type') }}</th>
                            <th>{{ __('text.txt_image') }}</th>
                            <th>{{ __('text.txt_sku') }}</th>
                            <th>{{ __('text.txt_name') }}</th>
                            <th>{{ __('text.txt_unit') }}</th>
                            <th>{{ __('text.txt_price') }}</th>
                            <th>{{ __('text.txt_rating') }}</th>
                            <th>{{ __('text.txt_action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr class="text-center">
                                <td>{{ $item->id }}</td>
                                <td nowrap>
                                    @if ($item->is_active)
                                        <label class="badge badge-opacity-info"><i class="icon-check"></i></label>
                                    @else
                                        <label class="badge badge-opacity-danger"><i
                                                class="icon-circle-minus"></i></label>
                                    @endif
                                </td>
                                <td>
                                    {{ $item->category ? $item->category->translated->name : null }}
                                </td>
                                <td nowrap>
                                    @if ($item->material)
                                        <small><span
                                                class="text-success fw-bold">{{ __('text.txt_material') }}</span></small>
                                    @else
                                        <small><span
                                                class="text-primary fw-bold">{{ __('text.txt_product_finished') }}</span></small>
                                    @endif
                                </td>
                                <td>
                                    <img onclick="showImagePopup('{{ asset($item->getImage()) }}')" class="list-image cursor-pointer" src="{{ asset($item->getImage()) }}" />
                                </td>
                                <td>
                                    <small class="text-danger fw-bold">{{ $item->sku }}</small>
                                </td>
                                <td class="text-start">
                                    <span class="title cursor-pointer" wire:click="edit({{ $item->id }})">
                                        {{ $item->translated->name }}
                                    </span>
                                    <br />
                                    <div class="sub-title mt-2">
                                        {{ optional($item->supplier)->name }}
                                    </div>
                                </td>
                                <td>{{ $item->unit }}</td>
                                <td nowrap>
                                    @if ($item->price > 0)
                                        <span class="text-success">{{ myCurrency($item->price) }} VND</span>
                                    @else
                                        <span class="text-danger">00</span>
                                    @endif
                                </td>
                                <td>{{ $item->rating }}</td>
                                <td nowrap>
                                    @include('livewire.admin.blocks.index_action_buttons', [
                                        'item' => $item,
                                    ])
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="links mt-3 text-right">{!! $links !!}</div>
            </div>
        </div>
    </div>
</div>
