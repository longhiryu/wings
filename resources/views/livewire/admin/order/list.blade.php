<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <div class="row">
                    <div class="col-12 col-md-6">
                        {{ __('text.txt_product_list') }}
                    </div>
                    <div class="col-12 col-md-6 d-flex justify-content-end">
                        @include('livewire.admin.blocks.add_new_button', ['model' => $model])
                    </div>
                </div>

            </h4>
            <p class="card-description">
                Danh sách hiển thị Đơn hàng, số lượng trong đơn hàng này không phải là số lượng xuất kho thực tế, bạn phải tạo "Phiếu xuất kho" cho Đơn hàng này, lúc đó số lượng của tồn kho mới được cập nhật.
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
                            <th>{{ __('text.txt_name') }}</th>
                            <th>{{ __('text.txt_code') }}</th>
                            <th>{{ __('text.txt_exported') }}</th>
                            <th>{{ __('text.customer') }}</th>
                            <th>{{ __('text.order_source') }}</th>
                            <th>{{ __('text.txt_action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr class="text-center">
                                <td>{{ $item->id }}</td>
                                <td nowrap>
                                    <span class="title cursor-pointer" wire:click="edit({{ $item->id }})">
                                        {{ $item->name }}
                                    </span>
                                </td>
                                <td>
                                    {{ $item->code }}
                                </td>
                                <td nowrap>
                                    @if ($item->exported)
                                        <label class="badge badge-opacity-info">
                                            Đã xuất hàng
                                        </label>
                                    @else
                                        <label class="badge badge-opacity-danger">
                                            Chưa xuất hàng
                                        </label>
                                    @endif

                                </td>
                                <td>
                                    {{ optional($item->customer)->presentation_name }}
                                </td>
                                <td nowrap>
                                    {{ $item->source }}
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
