<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <div class="row">
                    <div class="col-12 col-md-6">
                        {{ __('text.import_list') }}
                    </div>
                    <div class="col-12 col-md-6 d-flex justify-content-end">
                        @include('livewire.admin.blocks.add_new_button', ['model' => $model])
                    </div>
                </div>

            </h4>
            <p class="card-description">
                Danh sách hiển thị Nhập hàng, bạn có thể nhập "từ khóa" vào ô tìm
                kiếm để lọc dữ liệu mà bạn cần.
            </p>

            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>{{ __('text.user') }}</label>
                        <select class="form-control form-control-sm" wire:model="user_id">
                            <option value="">{{ __('text.txt_default') }}</option>
                            @foreach ($users as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
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
                <div class="col-3">
                    <div class="form-group">
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
                            {{-- <th>ID</th> --}}
                            <th>{{ __('text.txt_code') }}</th>
                            <th>{{ __('text.txt_status') }}</th>
                            <th>{{ __('text.txt_name') }}</th>
                            <th>{{ __('text.txt_creator') }}</th>
                            <th>Nguồn nhập</th>
                            <th>{{ __('text.inventory') }}</th>
                            <th>{{ __('text.txt_value') }} chưa thuế</th>
                            <th>{{ __('text.txt_action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr class="text-center">
                                {{-- <td>{{ $item->id }}</td> --}}
                                <td>
                                    <span class="text-danger fw-bold">{{ $item->code }}</span>
                                </td>
                                <td nowrap>
                                    @if ($item->is_imported)
                                        <label class="badge badge-opacity-info">
                                            {{ __('text.txt_received') }}
                                        </label>
                                    @else
                                        <label class="badge badge-opacity-danger">
                                            {{ __('text.txt_un_received') }}
                                        </label>
                                    @endif
                                </td>
                                <td class="text-start">
                                    <span class="title cursor-pointer" wire:click="edit({{ $item->id }})">
                                        {{ $item->name }}
                                    </span>
                                    <div class="text_sub_description">
                                        @if ($item->is_imported)
                                            Ngày nhập:
                                            {{ $item->import_date ? formatDateTime($item->import_date, 'date') : null }}
                                        @else
                                            Ngày tạo: {{ formatDateTime($item->created_at, 'date') }}
                                        @endif
                                    </div>
                                </td>
                                <td class="">
                                    {{ optional($item->user)->name }}
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-warning text-body fw-bold">
                                        {{ optional($item->supplier)->name ?? (optional($item->customer)->presentation_name ?? $types[$item->type]) }}
                                    </span>
                                </td>
                                <td class="text-primary fw-bold">
                                    {{ optional($item->inventory)->name }}
                                </td>
                                <td class="text-success fw-bold text-end">
                                    {{ my_format_number($item->getImportTotalValue()) }}
                                </td>
                                <td nowrap>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <button class="my-button btn btn-secondary text-dark me-2" data-toggle="modal"
                                            data-target="#modal_import" {{ !$item->is_imported ?: 'disabled' }}
                                            wire:click="modalImportInventory('{{ $item->id }}')">
                                            <i class="fa-solid fa-truck-fast"></i> Nhập kho
                                        </button>
                                        <button class="my-button btn btn-secondary text-dark me-2"
                                            wire:click="print('{{ $item->id }}')" wire:loading.attr="disabled">
                                            <div wire:loading wire:target="print('{{ $item->id }}')">
                                                <div class="d-flex align-content-center justify-content-center"><i
                                                        class="fa-solid fa-spinner fa-spin"></i></div>
                                            </div>
                                            <i class="fa-solid fa-download" wire:loading.remove
                                                wire:target="print('{{ $item->id }}')"></i> PDF
                                        </button>
                                        @include('livewire.admin.blocks.index_action_buttons', [
                                            'item' => $item,
                                        ])
                                    </div>

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
