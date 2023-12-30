<div class="rounded-2 border p-4" style="background-color: #FFFBF5">
    @error('product_list')
        <span class="error text-danger">{{ $message }}</span>
    @enderror
    <div class="form-group">
        {{-- <label for="category_id">{{ __('text.product') }}</label> --}}
        <div wire:key="product-iteration-{{ $product_iteration }}">
            <div class="select2-purple" wire:ignore>
                @if ($products)
                    <select class="select-2 select2 p-0" id="product_list" data-placeholder="Chọn sản phẩm"
                        data-dropdown-css-class="select2-purple" style="width: 100%;">
                        <option>Chọn sản phẩm</option>
                        @foreach ($products as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->sku }}
                                -
                                {{ $item->translated->name }}
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
                <th>Hình ảnh</th>
                <th>SKU</th>
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
                        <td>
                            <img class="list-image cursor-pointer" src="{{ asset($item['image']) }}"/>
                        </td>
                        <td>
                            <span class="text-danger fw-bold">{{ $item['sku'] }}</span>
                        </td>
                        <td>
                            <span class="fw-bold">{{ $item['product_name'] }}</span>
                        </td>
                        <td class="text-center">
                            <div class="form-group mb-0">
                                {{ $item['product_unit'] }}
                            </div>
                        </td>
                        <td>
                            <div class="form-group mb-0">
                                <input class="form-control form-control-sm text-center" type="number"
                                    value="{{ $item['product_quantity'] }}" 
                                    wire:change="updateProductList('product_quantity','{{ $item['sku_random'] }}', $event.target.value)">
                            </div>
                        </td>
                        <td>
                            <div class="form-group mb-0">
                                <input class="form-control form-control-sm text-center" type="number"
                                    value="{{ $item['product_price'] }}" 
                                    wire:change="updateProductList('product_price','{{ $item['sku_random'] }}', $event.target.value)">
                            </div>
                        </td>
                        <td class="text-end">
                            {{ my_format_number($item['product_price'] * $item['product_quantity']) }}
                        </td>
                        <?php $total += $item['product_price'] * $item['product_quantity']; ?>
                    </tr>
                @endforeach
                <tr class="fw-bold">
                    <td class="text-end" colspan="7">Tổng cộng:</td>
                    <td class="text-end">{{ my_format_number($total) }}</td>
                </tr>
                <tr class="fw-bold">
                    <td class="text-end" colspan="7">
                        {{ is_numeric($this->object->tax) ? null : 'Bạn chưa chọn mức '}}
                        Thuế  ({{ is_numeric($this->object->tax) ? $this->object->tax.'%' : null }}):
                    </td>
                    <td class="text-end">{{ is_numeric($this->object->tax) ? my_format_number($total * $object->tax / 100) : 0 }}</td>
                </tr>
                <tr class="fw-bold">
                    <td class="text-end" colspan="7">
                        Giá trị Dự án / PO:
                    </td>
                    <td class="text-end">{{ is_numeric($this->object->tax) ? my_format_number($total + $total * $object->tax / 100) : 0 }}</td>
                </tr>
            </tbody>
        </table>
    @endif
    {{-- <button type="button" wire:click="check_list()">Check</button> --}}
</div>
