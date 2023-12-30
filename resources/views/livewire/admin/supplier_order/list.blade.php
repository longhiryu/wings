<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <div class="row">
                    <div class="col-12 col-md-6">
                        Đơn đặt hàng Nhà Cung Cấp - Supplier Order
                    </div>
                    <div class="col-12 col-md-6 d-flex justify-content-end">
                        @include('livewire.admin.blocks.add_new_button', ['model' => $model])
                    </div>
                </div>

            </h4>
            <p class="card-description">
                Danh sách Đơn đặt hàng, bạn có thể nhập "từ khóa" vào ô tìm
                kiếm để lọc dữ liệu mà bạn cần.
            </p>
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        @include('livewire.admin.blocks.search_input')
                    </div>
                </div>
            </div>
            <div style="width: 100%" wire:loading wire:target="keyword">
                <div class="d-flex align-content-center justify-content-center"><i
                        class="fa-solid fa-spinner fa-spin"></i></div>
            </div>
            <div class="table-responsive">
                <table class="table-striped list table">
                    <thead>
                        <tr class="text-center">
                            <th>Mã</th>
                            <th>{{ __('text.txt_name') }}</th>
                            <th>Nhà cung cấp</th>
                            <th>Người tạo</th>
                            <th>Xác nhận</th>
                            <th>Đã gửi mail</th>
                            <th>Gửi mail NCC</th>
                            <th>{{ __('text.txt_action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr class="text-center">
                                <td>
                                    <span class="text-danger fw-bold">{{ $item->code }}</span>
                                </td>
                                <td class="text-start">
                                    <span class="title cursor-pointer" wire:click="edit({{ $item->id }})">
                                        {{ $item->name }}
                                    </span>
                                </td>
                                <td>
                                    {{ optional($item->supplier)->name }}
                                </td>
                                <td class="">
                                    {{ optional($item->creator)->name }}
                                </td>
                                <td class="text-start">
                                    {{ $item->is_confirmed }}
                                </td>
                                <td>
                                    {!! formatDateTime($item->sent_email_at, 'datetime') !!}
                                </td>
                                <td class="text-center">
                                    <button class="my-button btn btn-warning text-dark me-2"
                                        wire:click="sentMailToSupplier({{ $item->id }})" wire:loading.attr="disabled">
                                        <div wire:loading wire:target="sentMailToSupplier('{{ $item->id }}')">
                                            <div class="d-flex align-content-center justify-content-center"><i
                                                    class="fa-solid fa-spinner fa-spin"></i></div>
                                        </div>
                                        <i class="fa-solid fa-paper-plane" wire:loading.remove
                                        wire:target="sentMailToSupplier('{{ $item->id }}')"></i> Gửi mail NCC
                                    </button>
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
