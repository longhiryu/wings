<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-0">
                <div class="row">
                    <div class="col-12 col-md-6">
                        {{ __('text.txt_product_list') }}
                    </div>
                    <div class="col-12 col-md-6 d-flex justify-content-end">
                        @include('livewire.admin.blocks.add_new_button', ['model' => $model])
                    </div>
                </div>

            </h4>
            <p class="card-description text-dark-50">
                Danh sách hiển thị Người dùng, bạn có nhập "từ khóa" vào ô tìm
                kiếm để lọc dữ liệu mà bạn cần.
            </p>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
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
                            <th class="text-start">{{ __('text.txt_group') }}</th>
                            <th class="text-start">{{ __('text.txt_name') }}</th>
                            <th class="text-start">{{ __('text.txt_email') }}</th>
                            <th class="text-start">{{ __('text.txt_phone') }}</th>
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
                                <td class="text-start">
                                    @if ($item->group)
                                        {{ $item->group()->first()->name }}
                                    @endif
                                </td>
                                <td class="text-start">
                                    <span class="title cursor-pointer" wire:click="edit({{ $item->id }})">
                                        {{ $item->name }}
                                    </span>
                                </td>
                                <td class="text-start">
                                    {{ $item->email }}
                                </td>
                                <td class="text-start">
                                    {{ $item->phone }}
                                </td>
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
