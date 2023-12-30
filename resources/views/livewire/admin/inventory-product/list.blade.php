<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <div class="row">
                    <div class="col-12 col-md-6">
                        {{ __('text.stock_list') }}
                    </div>
                    <div class="col-12 col-md-6 d-flex justify-content-end">
                        @include('livewire.admin.blocks.add_new_button', ['model' => $model])
                    </div>
                </div>

            </h4>
            <p class="card-description">
                Danh sách hiển thị tồn kho, bạn có thể nhập "từ khóa" vào ô tìm
                kiếm để lọc dữ liệu mà bạn cần.
            </p>
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>{{ __('text.supplier') }}</label>
                        <select class="form-control form-control-sm" wire:model="supplier_id">
                            <option value="">{{ __('text.txt_default') }}</option>
                            @foreach ($suppliers as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>{{ __('text.inventory') }}</label>
                        <select class="form-control form-control-sm" wire:model="inventory_id">
                            <option value="">{{ __('text.txt_default') }}</option>
                            @foreach ($inventories as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-4 form-group">
                    @include('livewire.admin.blocks.search_input')
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <div class="form-check form-check-flat form-check-primary" style="margin-top: 40px">
                            <label class="form-check-label">
                              <input type="checkbox" class="form-check-input" wire:model="low_quantity" value="1">
                              {{ __('text.txt_low_quantity') }}
                            <i class="input-helper"></i></label>
                          </div>
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
                            {{-- <th>{{ __('text.txt_status') }}</th> --}}
                            <th>{{ __('text.txt_sku') }}</th>
                            <th>{{ __('text.txt_name') }}</th>
                            <th>{{ __('text.project') }}</th>
                            <th>{{ __('text.txt_quantity') }}</th>
                            <th>{{ __('text.txt_unit') }}</th>
                            <th>Nguồn nhập</th>
                            <th>{{ __('text.inventory') }}</th>
                            <th>Giá trị</th>
                            {{-- <th>{{ __('text.txt_action') }}</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <?php $types = config('import.types') ?>
                        @foreach ($data as $item)
                            <tr class="text-center">
                                <td>{{ $item->id }}</td>
                                <td class="fw-bold text-danger">{{ $item->product->sku }}</td>
                                <td class="text-start">
                                    <span class="title cursor-pointer" wire:click="edit({{ $item->id }})">
                                        {{ $item->product->translated->name }} 
                                        @if($item->product_quantity <= 10)
                                            - <span class='text-danger text-lowercase'>{{ __('text.txt_low_quantity') }}</span>
                                        @endif
                                        <br />
                                    <small class="sub-title">Tên lưu kho: <span class="text-body">{{ $item->product_name }}</span></small>
                                    </span>
                                </td>
                                <td>
                                    {{ optional($item->project)->name }}
                                </td>
                                <td class="fw-bold {{ ($item->product_quantity <= 10) ? 'text-danger' : null}}">
                                    {{ my_format_number($item->product_quantity) }}
                                </td>
                                <td class="fw-semibold">
                                    {{ $item->product_unit }}
                                </td>
                                <td class="">
                                    <i class="fa-solid fa-store text-black-50"></i>
                                    
                                    {{ optional($item->supplier)->name ?? optional($item->customer)->presentation_name ?? $types[$item->type]}}
                                </td>
                                <td class="">
                                    <i class="fa-solid fa-warehouse text-black-50"></i>
                                    {{ optional($item->inventory)->name }}
                                </td>
                                <td class="text-success fw-bold">
                                    {{ my_format_number($item->getProductTotalValue($item->id)) }}
                                </td>
                                {{-- <td nowrap>
                                    @include('livewire.admin.blocks.index_action_buttons', [
                                        'item' => $item,
                                    ])
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="links mt-3 text-right">{!! $links !!}</div>
            </div>
        </div>
    </div>
</div>
