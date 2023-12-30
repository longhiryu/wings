<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-0">
                <div class="row">
                    <div class="col-12 col-md-6">
                        {{ __('text.txt_category_list') }}
                    </div>
                    <div class="col-12 col-md-6 d-flex justify-content-end">
                        @include('livewire.admin.blocks.add_new_button', ['model' => $model])
                    </div>
                </div>
            </h4>
            <p class="card-description text-black-50">
                Danh sách hiển thị Nhóm (bài viết hoặc sản phẩm), bạn có thể chọn "Danh mục cha" hoặc nhập "từ khóa" vào ô tìm kiếm để lọc dữ liệu mà bạn cần.
            </p>
            <div class="form-group">
                <div class="row">
                    <div class="col-4">
                        <label>{{ __('text.category_parent') }}</label>
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
                        <label>{{ __('text.txt_keyword') }}</label>
                        <input class="form-control table-index-search" type="text" wire:model='keyword'
                            placeholder="{{ __('text.txt_search') }}">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table-striped list table">
                    <thead>
                        <tr class="text-center">
                            <th>ID</th>
                            <th>{{ __('text.txt_status') }}</th>
                            <th>{{ __('text.txt_image') }}</th>
                            <th>{{ __('text.txt_type') }}</th>
                            <th class="text-start">{{ __('text.txt_name') }}</th>

                            <th class="text-end">{{ __('text.txt_action') }}</th>
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
                                    <img class="list-image cursor-pointer" src="{{ asset($item->getImage()) }}"
                                        wire:click="edit({{ $item->id }})" />
                                </td>
                                <td>{{ __('text.' . $item->type) }}</td>
                                <td class="text-start">
                                    <span class="title cursor-pointer" wire:click="edit({{ $item->id }})">
                                        {{ $item->translate('name') }}
                                    </span>

                                    @if ($item->parent)
                                        <div class="sub-title mt-2">
                                            (
                                            @if ($item->parent->parent)
                                                {{ $item->parent->parent->translate('name') }} -
                                            @endif
                                            {{ $item->parent->translate('name') }}
                                            {{-- <span class="fw-bold text-primary cursor-pointer hover" wire:click="edit({{ $item->parent->id }})">
                                            {{ $item->parent->translate('name') }}
                                        </span> --}}
                                            )
                                        </div>
                                    @endif

                                </td>

                                <td class="text-end" nowrap>
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
