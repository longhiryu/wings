<!-- Modal HTML -->
<div class="modal fade modal-files" id="modal_import" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
    tabindex="-1" wire:ignore.self>
    <div class="modal-dialog modal-confirm modal-lg">
        @if ($modal_import)
            <div class="modal-content">
                <div class="modal-body py-3">
                    <div class="py-3">
                        <div class="text-uppercase text_header text-center">{{ $modal_import->name }}</div>
                        <div class="text-uppercase text_header text-center">
                            @if ($modal_import->is_imported)
                                <span class="text-success fw-bold text_sub_description">(Phiếu đã được nhập kho)</span>
                            @else
                                <span class="text-danger fw-bold text_sub_description">(Chưa nhập kho)</span>
                            @endif
                        </div>

                        <div class="text_description">
                            Người tạo phiếu: <span class="text-black fw-bold">{{ $modal_import->user->name }}</span>
                        </div>
                        <div class="text_description">
                            Nguồn nhập: 
                            <span class="text-black fw-bold">
                                {{ optional($modal_import->supplier)->name ?? optional($modal_import->customer)->presentation_name ?? $types[$modal_import->type]}}
                            </span>
                        </div>
                        <div class="text_description">
                            Kho nhập: <span class="text-black fw-bold">{{ $modal_import->inventory->name }}</span>
                        </div>
                        <div class="text_description">
                            Ngày tạo phiếu: <span class="text-black fw-bold">{{ formatDateTime($modal_import->created_at, 'datetime') }}</span>
                        </div>

                    </div>
                    <table class="table-striped modal_import table border">
                        <thead class="text-center">
                            <th>SKU</th>
                            <th>{{ __('text.txt_name') }}</th>
                            <th>{{ __('text.txt_unit') }}</th>
                            <th>{{ __('text.product_import_price') }}</th>
                            <th>{{ __('text.txt_quantity') }}</th>
                            <th>{{ __('text.txt_sub_total') }}</th>
                        </thead>
                        <tbody>
                            <?php 
                                $products = json_decode($modal_import->items, true);
                                $total = 0;
                                ?>
                            @foreach ($products as $item)
                                <tr class="text-center">
                                    <td class="my-3">{{ $item['sku'] }}</td>
                                    <td class="text-start fw-bold">{{ $item['product_name'] }}</td>
                                    <td class="fw-bold">{{ $item['product_unit'] }}</td>
                                    <td class="text-danger fw-bold">{{ my_format_number($item['import_price']) }}
                                    </td>
                                    <td class="text-primary fw-bold">
                                        {{ my_format_number($item['product_quantity']) }}</td>
                                    <td class="text-success fw-bold">
                                        {{ my_format_number($item['import_price'] * $item['product_quantity']) }}</td>
                                </tr>
                                <?php $total += $item['import_price'] * $item['product_quantity']; ?>
                            @endforeach
                            <tr>
                                <td class="text-end fw-bold" colspan="5">{{ __('text.txt_total') }}</td>
                                <td class="text-success fw-bold text-center">{{ my_format_number($total) }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="mt-4">
                        <div class="fw-bold mb-2">Ghi chú: </div>
                        {!! $modal_import->note !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="container-fluid p-0">
                        <div class="row px-0">
                            <div class="col-md-6">
                                @if (!$modal_import->is_imported)
                                    <button class="my-button btn btn-success me-2 text-white" data-dismiss="modal"
                                        type="button"
                                        wire:click="importToInventory('{{ $modal_import->id }}')">{{ __('text.txt_import_inventory') }}</button>
                                @endif

                            </div>
                            <div class="col-md-6 text-end">
                                <button class="my-button btn btn-secondary text-dark me-2" data-dismiss="modal"
                                    type="button">{{ __('text.txt_close') }}</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endif
    </div>
</div>
