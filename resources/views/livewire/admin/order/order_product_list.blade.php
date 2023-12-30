<div class="rounded-2 mt-4 border p-4" style="background-color: #FFFBF5">
    <div>
        <h4>Đơn hàng</h4>
    </div>
    @error('product_list')
        <span class="error text-danger">{{ $message }}</span>
    @enderror
    <div class="form-group">
        <label for="category_id">{{ __('text.product') }}</label>
        <div wire:key="product-iteration-{{ $product_iteration }}">
            <div class="select2-purple" wire:ignore>
                @if ($products)
                    <select class="select-2 select2 p-0" id="product_list" data-placeholder="Chọn sản phẩm"
                        data-dropdown-css-class="select2-purple" style="width: 100%;" {{ $object->exported ? 'disabled' : null }}>
                        <option>Chọn sản phẩm</option>
                        @foreach ($products as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->translate('name') }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>
    </div>
    @if ($product_list)
        <table class="table-striped list table border">
            <thead class="text-center">
                <th></th>
                <th>Tên sản phẩm</th>
                <th>Đơn vị tính</th>
                <th>Số lượng</th>
                <th>Đơn giá bán</th>
                <th>Thành tiền</th>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                @foreach ($product_list as $item)
                    <tr>
                        <td>
                            <span class="text-danger cursor-pointer"
                                wire:click="removeProductFromList('{{ $item['sku_random'] }}')">
                                <i class="fa-solid fa-trash-can"></i>
                            </span>
                        </td>
                        <td>{{ $item['product_name'] }}</td>
                        <td>
                            <div class="form-group mb-0">
                                <input class="form-control form-control-sm text-center" type="text" value="pcs" {{ $disable ? 'disabled' : null }}
                                    wire:change="updateProductList('product_unit','{{ $item['sku_random'] }}', $event.target.value)">
                            </div>
                        </td>
                        <td>
                            <div class="form-group mb-0">
                                <input class="form-control form-control-sm text-center" type="number"
                                    value="{{ $item['product_quantity'] }}" {{ $disable ? 'disabled' : null }}
                                    wire:change="updateProductList('product_quantity','{{ $item['sku_random'] }}', $event.target.value)">
                            </div>
                        </td>
                        <td>
                            <div class="form-group mb-0">
                                <input class="form-control form-control-sm text-center" type="number"
                                    value="{{ $item['product_price'] }}" {{ $disable ? 'disabled' : null }}
                                    wire:change="updateProductList('product_price','{{ $item['sku_random'] }}', $event.target.value)">
                            </div>
                        </td>
                        <td class="text-center">
                            {{ my_format_number($item['product_price'] * $item['product_quantity']) }}
                        </td>
                        <?php $total += $item['product_price'] * $item['product_quantity']; ?>
                    </tr>
                @endforeach
                <tr class="fw-bold">
                    <td class="text-end" colspan="5">Tổng cộng:</td>
                    <td class="text-center">{{ my_format_number($total) }}</td>
                </tr>
            </tbody>
        </table>
    @endif
    {{-- <button type="button" wire:click="check_list()">Check</button> --}}
</div>
