<div class="rounded-2 mt-4 border p-4" style="background-color: #FFFBF5">
    <div>
        <h6>Danh sách đặt hàng</h6>
    </div>
    @error('product_list')
        <span class="error text-danger">{{ $message }}</span>
    @enderror
    <div class="form-group">
        <input class="form-control form-control-sm" wire:model="product_keyword" placeholder="tìm kiếm sản phẩm..." />
        @if ($products)
            <div class="table-responsive">
                <table class="table-striped list table-hover bg-light text_description table border">
                    <tbody>
                        @foreach ($products as $item)
                            <tr class="cursor-pointer" data-dismiss="modal"
                                wire:click="addProductToList('{{ $item->id }}')">
                                <td class="fw-bold text-danger text-center" width="10%">{{ optional($item)->sku }}
                                </td>
                                <td class="text-center" width="10%"><img class="list-image"
                                        src="{{ asset($item->getImage()) }}" /></td>
                                <td class="fw-bold" width="20%">{{ $item->translated->name }}</td>
                                <td class="text-center" width="20%">
                                    {{ optional($item->supplier)->name ?? optional($item->customer)->name }}</td>
                                <td class="text-center" width="5%">{{ $item->unit }}</td>
                                <td width="10%">{{ optional($item->category)->name ?? 'Chưa phân nhóm' }}</td>

                                <td class="text-center" width="10%">
                                    @if ($item->material)
                                        <small><span
                                                class="text-success fw-bold">{{ __('text.txt_material') }}</span></small>
                                    @else
                                        <small><span
                                                class="text-primary fw-bold">{{ __('text.txt_product_finished') }}</span></small>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
    @if ($this->product_list)
        <div wire:key="product-list-{{ $list_iteration }}">
            <table class="table-striped list rounded-2 table border">
                <thead class="text-center">
                    <th class="text-dark py-2">A.</th>
                    <th class="text-dark py-2">SKU</th>
                    <th class="text-dark py-2">Hình ảnh</th>
                    <th class="text-dark py-2">Tên sản phẩm</th>
                    <th class="text-dark py-2">Đơn vị tính</th>
                    <th class="text-dark py-2">Giá nhập</th>
                    <th class="text-dark py-2">Số lượng</th>
                    <th class="text-dark py-2">Thành tiền</th>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    @foreach ($this->product_list as $item)
                        <tr class="text-center">
                            <td>
                                <span class="text-danger cursor-pointer"
                                    wire:click="removeProductFromList('{{ $item['sku'] }}')"><i
                                        class="fa-solid fa-trash-can"></i></span>
                            </td>
                            <td>{{ $item['sku'] }}</td>
                            <td>
                                <img class="list-image cursor-pointer" src="{{ asset(getImageById($item['id'])) }}"
                                    onclick="showImagePopup('{{ asset(getImageById($item['id'])) }}')" />
                            </td>
                            <td class="text-start">{{ $item['name'] }}</td>
                            <td>
                                <div class="form-group mb-0">
                                    <input class="form-control form-control-sm text-center" type="text"
                                        value="{{ $item['unit'] }}" disabled
                                        wire:change="updateProductList('unit','{{ $item['sku'] }}', $event.target.value)">
                                </div>
                            </td>
                            <td>
                                <div class="form-group mb-0">
                                    <input class="form-control form-control-sm text-center" type="text"
                                        value="{{ $item['price'] }}" {{ !$this->object->is_imported ?: 'disabled' }}
                                        wire:change="updateProductList('price','{{ $item['sku'] }}', $event.target.value)">
                                </div>
                            </td>
                            <td>
                                <div class="form-group mb-0">
                                    <input class="form-control form-control-sm text-center" type="text"
                                        value="{{ $item['quantity'] }}"
                                        {{ !$this->object->is_imported ?: 'disabled' }}
                                        wire:change="updateProductList('quantity','{{ $item['sku'] }}', $event.target.value)">
                                </div>
                            </td>
                            <td class="text-end">
                                @if ($item['price'] && $item['quantity'])
                                    {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                @else
                                    0
                                @endif
                            </td>
                        </tr>
                        <?php $total += $item['price'] * $item['quantity']; ?>
                    @endforeach
                    <tr>
                        <td class="text-end" colspan="7">Tổng cộng (chưa thuế)</td>
                        <td class="fw-bold text-end text-success sub-total">{{ number_format($total, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-end" colspan="7">Thuế ({{ $object->tax }}%)</td>
                        <td class="fw-bold text-end text-danger tax-total">{{ number_format(($total * $object->tax) / 100, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-end" colspan="7">Thành tiền</td>
                        <td class="fw-bold text-end text-primary grand-total">
                            {{ number_format($total + ($total * $object->tax) / 100, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    @endif
</div>
