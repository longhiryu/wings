<div class="rounded-2 mt-4 border p-4" style="background-color: #ECF7FF">
    <div>
        <h4>Phiếu xuất kho</h4>
    </div>
    @error('product_export_list')
        <span class="error text-danger">{{ $message }}</span>
    @enderror
    <div class="form-group">
        <label for="category_id">{{ __('text.product') }}</label>
        <div wire:key="stock-iteration-{{ $stock_iteration }}">
            <div class="select2-purple" wire:ignore>
                @if ($stocks)
                    <select class="select-2 select2 p-0" id="product_export_list" data-dropdown-css-class="select2-purple"
                        style="width: 100%;" {{ $object->exported ? 'disabled' : null }}>
                        <option>Chọn tồn kho</option>
                        @foreach ($stocks as $item)
                            <option value="{{ $item->id }}">
                                ({{ my_format_number($item->product_quantity) }})
                                | {{ $item->product_name }} - [{{ $item->supplier->name }}] -
                                [{{ my_format_number($item->import_price) }}] - [{{ my_format_number($item->selling_price) }}]
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>
    </div>
    @if ($product_export_list)
        <div wire:key="export-table-{{ $export_iteration }}">
            <table class="table-striped list table border">
                <thead class="text-center">
                    <th></th>
                    <th>Tên sản phẩm</th>
                    <th>Đơn vị tính</th>
                    <th>Số lượng</th>
                </thead>
                <tbody>
                    @foreach ($product_export_list as $item)
                        <tr>
                            <td class="text-center">
                                <span class="text-danger cursor-pointer"
                                    wire:click="removeProductFromExportList('{{ $item['sku_random'] }}')">
                                    <i class="fa-solid fa-trash-can"></i>
                                </span>
                            </td>
                            <td>
                                <span>
                                    <h6>{{ $item['product_name'] }} - [{{ my_format_number($item['import_price']) }}] -
                                        [{{ my_format_number($item['selling_price']) }}]</h6>
                                </span>
                                <div class="pb-1">
                                    <i class="fa-fw fa-solid fa-receipt"></i> {{ $item['name'] }}
                                </div>
                                <div class="pb-1">
                                    <i class="fa-fw fa-solid fa-cubes-stacked"></i>
                                    {{ my_format_number($item['stock']) . ' ' . $item['product_unit'] }}
                                </div>
                                <div class="pb-1">
                                    <i class="fa-fw fa-solid fa-store"></i> {{ $item['supplier'] }}
                                </div>
                                <div class="pb-1">
                                    <i class="fa-fw fa-solid fa-warehouse"></i> {{ $item['inventory'] }}
                                </div>
                                @if ($item['stock'] < $item['export_quantity'])
                                    <span class="text-danger">(số lượng vượt quá tồn kho)</span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $item['product_unit'] }}
                            </td>
                            <td>
                                <div class="form-group mb-0">
                                    <input class="form-control form-control-sm text-center" type="number"
                                        value="{{ $item['export_quantity'] }}" max="{{ $item['stock'] }}" {{ $disable ? 'disabled' : null }}
                                        wire:change="updateProductExportList('export_quantity','{{ $item['sku_random'] }}', $event.target.value, {{ $item['stock'] }})">
                                    @error('export_quantity')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </td>
                            {{-- <td>
                        <div class="form-group mb-0">
                            <input class="form-control form-control-sm text-center"
                                type="number" value="{{ $item['product_price'] }}"
                                wire:change="updateProductList('product_price','{{ $item['sku_random'] }}', $event.target.value)">
                        </div>
                    </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    {{-- <button type="button" wire:click="check_list()">Check</button> --}}
</div>
